<style>
  i.fa.fa-edit {
    font-size: 20px;
    color: green;
  }

  i.fa-sharp.fa-solid.fa-trash {
    font-size: 20px;
    color: green;
  }

   .status-text {
    font-weight: 600;
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
.detail-row {
  display: flex;
  margin-bottom: 6px;
  align-items: flex-start;
  font-size: 14px;
  color: #333;
}

.detail-label {
  min-width: 130px;
  font-weight: 500;
  color: #506018;
}

.detail-colon {
  padding: 0 5px;
}

.detail-value {
  flex: 1;
  font-weight: 500;
  white-space: nowrap;
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
      <h4 class="mb-sm-0">Vendor Bill Approval</h4>
      <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
        value="<?php echo $screen_id_val; ?>">
      <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
        value="<?php echo $user_type_unique_id; ?>">

      <div class="page-title-right">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="javascript: void(0);">Vendor Payment</a></li>
          <li class="breadcrumb-item active">Vendor Bill Approval</li>
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
            <span class="d-none d-sm-block">Vendor Bill Approval Pending</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#arrow-contact" role="tab">
            <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
            <span class="d-none d-sm-block">Vendor Bill Complete</span>
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
                     <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Created Date / Bill No</th>
      <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Invoice Date / Invoice No</th>
                      <th style="text-align:center;">Vendor Name</th>
                         <th style="text-align:center; white-space: nowrap; width: 80px;">Dc Count</th>
                      <th style="text-align:center;"> Bill Amount</th>
                        <th style="text-align:center;">Status</th>
                       <th style="text-align:center;">Rejected By</th>
                          <th style="text-align:center;">Rejected Reason</th>
                      <th style="text-align:center;">Remarks</th>

                      <!-- <th style="text-align:center;">Remarks</th> -->

                      <th style="text-align:center;">Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="arrow-contact" role="tabpanel">
          <div class="row mb-4">
            <div class="col-3">
              <label class="form-label">From Date</label>
              <input type="date" name="from_date" id="from_date" class="form-control" id="from_date">
            </div>
            <div class="col-3">
              <label class="form-label">To Date</label>
              <input type="date" name="from_date" id="to_date" class="form-control" id="from_date">
            </div>

             <div class="col-3">
             
             <button type="button" class="btn btn-primary" id="gofilter" onclick="completed_datatable('vendorpayment_datatable_completed','','datatable_completed')">Go</button>
            </div>
          </div>
         <table id="vendorpayment_datatable_completed" class="table table-bordered table-striped align-middle">
  <thead>
    <tr>
      <th style="text-align:center; white-space: nowrap; width: 50px;">S.No</th>
      <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Bill Date / Bill No</th>
      <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Invoice Date / Invoice No</th>
      <th style="text-align:center; white-space: nowrap; width: 200px;">Vendor Name</th>
      <th style="text-align:center; white-space: nowrap; width: 80px;">Dc Count</th>
      <th style="text-align:center; white-space: nowrap; width: 100px;">Bill Amount</th>
      <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Bill Approveby /Date</th>
      <th style="text-align:center; white-space: nowrap; width: 80px;">Action</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end card-body -->
<!-- First Modal: Vendor Bill Approval -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog custom-wide-modal modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header"
           style="background-color: #d6d8b3; color: #506018 !important; font-weight: bold; border-top-left-radius: 0.3rem; border-top-right-radius: 0.3rem; padding: 0.8rem !important;">
        <h5 class="modal-title fw-bold text-center w-100" style="color: #506018 !important;" id="viewModalLabel">Vendor Bill Approval</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="viewModalBody" style="background-color: #f9fafb;">
        <div class="container-fluid">
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;"> Vendor Details</h6>
                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="vendor_com_name_popup_1"></span></strong><br><strong><span id="vendor_name_popup_1"></span></strong></h6>
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
                <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor Bill Details</h6>
                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="bill_no_1"></span></strong></h6>
                  <p class="mb-1"><i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i>
                    <b><span id="bill_date_1"></span></b>
                  </p>
                </div>
                <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary mb-3" style="font-size: large; color: #878a99;">Vendor Bank Details</h6>
                  
                  <div class="detail-row"><div class="detail-label">Bank Name</div><div class="detail-colon">:</div><div class="detail-value" id="bank_name_popup_1"></div></div>
                  <div class="detail-row"><div class="detail-label">Branch</div><div class="detail-colon">:</div><div class="detail-value"><i data-feather="map-pin" style="width:15px; height:15px;"></i><span id="bank_branch_popup_1"></span></div></div>
                  <div class="detail-row"><div class="detail-label">Account No</div><div class="detail-colon">:</div><div class="detail-value" id="acc_no_popup_1"></div></div>
                  <div class="detail-row"><div class="detail-label">IFSC Code</div><div class="detail-colon">:</div><div class="detail-value" id="ifsc_popup_1"></div></div>
                  <div class="detail-row"><div class="detail-label">Account Holder</div><div class="detail-colon">:</div><div class="detail-value" id="acc_holder_popup_1"></div></div>
                  <div class="detail-row"><div class="detail-label">PAN Copy</div><div class="detail-colon">:</div><div class="detail-value" id="pan_popup_1"></div></div>
                  <div class="detail-row"><div class="detail-label">Bank Proof</div><div class="detail-colon">:</div><div class="detail-value" id="bank_popup_1"></div></div>
                </div>
              </div>
            <!-- </div> -->
          <!-- </div> -->
        <div class="row">
            <div class="col-md-4"></div>

            <div class="col-md-4" style="margin-top: -165px;">
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
             <p class="mb-1">
             <b>PO Attach: <span id="ven_po_attach_1"></span></b>
            </p>
             <p class="mb-1">
                  <b>Bill Created By: <span id="vendor_by"></span></b>
            </p>
             <p class="mb-1">
                  <b>Bill Created Date: <span id="vendor_date"></span></b>
            </p>
            </div>

          
        </div>

        

          <input type="hidden" name="po_num" id="po_num_1">
          <input type="hidden" name="vendor_name" id="vendor_name_1">

          <!-- <div class="card border-0 shadow-sm"> -->
            <!-- <div class="card-body"> -->
              <h6 class="mb-3 fw-semibold text-success" style="color: #506018 !important;"><i class="bi bi-table"></i>
                Vendor Bill Approval Table</h6>
              <div class="table-responsive">
                <table id="vendor_datatable_1" class="table table-bordered table-striped table-hover align-middle">
                  <thead>
                    <tr>
                      <th style="text-align:center;">S NO</th>
                      <th style="text-align:center;">DC No. / Date</th>
                      <th style="text-align:center;">Invoice No. / Date</th>
                      <th style="text-align:center;">PO No. / Date</th>
                      <th style="text-align:center;">Invoice Qty</th>
                      <th style="text-align:center;">Consignee Address</th>
                    <th style="text-align:center;">Unit Price</th>
                        <th style="text-align:center;">Basic amount</th>
                        <th style="text-align:center;">GST</th>
                        <th style="text-align:center;">GST Amount</th>
                        <th style="text-align:center;">Total Amount</th>
                      <!-- <th style="text-align:center;">Status</th> -->
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>

  <div class="container-fluid px-3">
  <!-- Row 1: Remarks + Update + Total Amount (right aligned) -->
  <div class="row align-items-start mb-3">
    <div class="col-md-12 d-flex justify-content-between align-items-start">
      <!-- Left Side: Remarks + Update -->
      <div class="d-flex align-items-start flex-grow-1 me-3" style="max-width: 60%;">
        <div class="me-2" style="flex-basis: 70%;">
          <label class="form-label fw-semibold">Remarks</label>
          <textarea 
            class="form-control" 
            id="remark_1" 
            name="remark_1" 
            rows="4" 
            style="resize: none;" oninput="validateremark(this)" required
          ></textarea>
        </div>
        <!-- <div class="">
          <button 
            type="button" 
            class="btn btn-success mt-5" 
            style="height: 40px; white-space: nowrap;" 
            onclick="update_remark()">
            Update
          </button>
        </div> -->
      </div>

   <div class="row mt-3 px-3">
    <div class="col-md-12 d-flex justify-content-end align-items-center" >
    <span class="fw-bold me-2">Additional Charges:</span>
    <span class="fw-bold" id="additional_charges" style="font-size: 17px;"></span>
  </div>
  <div class="col-md-12 d-flex justify-content-end align-items-center" >
    <span class="fw-bold me-2">Total Amount:</span>
    <span class="fw-bold" id="ttl_span_amnt_1" style="font-size: 17px;"></span>
    <input type="hidden" id="ttl_amount_1" readonly>
  </div>
</div>


    </div>
  </div>

 <div class="row mt-4 align-items-start">
    <div class="col-md-6">
      <label class="form-label fw-semibold">Status:</label>
      <select 
        class="form-select" 
        id="ven_approval_sts" 
        name="ven_approval_sts" 
        style="width: 400px;"
      >
        <option value="1" selected>Approved</option>
        <option value="2">Reject</option>
      </select>
    </div>

   <!-- Reject Reason -->
<div class="col-md-5" id="rejectlabel" style="display: none; margin-left: -87px;">
  <label class="form-label fw-semibold">
    Reject Reason:<span class="text-danger">*</span>
  </label>
  <textarea 
    class="form-control required-textarea" 
    id="reject_reason" 
    name="reject_reason"  
    rows="3" 
    oninput="removeRedBorder(this)"
    placeholder="Enter reject reason"
    style="resize: none; display: block;" 
    required
  ></textarea>
  <small id="remarkError" class="text-danger" style="display: none;">This field is required</small>
</div>

<style>
/* Default red border */
.required-textarea {
    border: 1px solid red;
}
</style>
  </div>
</div>


<!-- Buttons -->
<div class="row">
  <div class="col-md-12 d-flex justify-content-end pt-2 pb-2">
    <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">
      <i class="bi bi-x-circle"></i> Close
    </button>
    <button type="button" class="btn btn-success" id="apprvl_btn_1" onclick="vendor_payment();update_remark();">
      Submit
    </button>
  </div>
</div>


          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Second Modal: Finance Team Approval -->
<div class="modal fade" id="viewModal-2" tabindex="-1" aria-labelledby="viewModalLabel2" aria-hidden="true">
  <div class="modal-dialog custom-wide-modal modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow-lg rounded-4 border-0">
      <div class="modal-header"
           style="background-color: #d6d8b3; color: #506018 !important; font-weight: bold; border-top-left-radius: 0.3rem; border-top-right-radius: 0.3rem; padding: 0.8rem !important;">
        <h5 class="modal-title fw-bold text-center w-100" style="color: #506018 !important;" id="viewModalLabel2">Vendor Bill Approval</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="viewModalBody2" style="background-color: #f9fafb;">
        <div class="container-fluid">
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;"> Vendor Details</h6>
                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="vendor_comname_popup_2"></span></strong><br><strong><span id="vendor_name_popup_2"></span></strong></h6>
                  <p class="mb-1"><i data-feather="map-pin" style="width:15px; height:15px; color:#506018"></i><span id="address_popup_2"></span></p>
                  <p class="mb-1">GST No: <b><span id="gst_no_popup_2"></span></b>, PAN No: <b><span id="pan_no_popup_2"></span></b></p>
                  <p class="mb-1"><i data-feather="mail" style="width:15px; height:15px; color:#506018"></i><span id="mail_popup_2"></span></p>
                  <p class="mb-1"><i data-feather="phone" style="width:15px; height:15px; color:#506018"></i><span id="contact_no_popup_2"></span></p>
                </div>
                <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor Bill Details</h6>
                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="bill_no_2"></span></strong></h6>
                  <p class="mb-1"><i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i><b><span id="bill_date_2"></span></b></p>
                </div>
                <!-- <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor Bank Details</h6>
                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="bank_name_popup_2"></span></strong></h6>
                  <p class="mb-1"><i data-feather="map-pin" style="width:15px; height:15px; color:#506018"></i><span id="bank_branch_popup_2"></span></p>
                  <p class="mb-1">Account No: <b><span id="acc_no_popup_2"></span></b></p>
                  <p class="mb-1">IFSC Code: <b><span id="ifsc_popup_2"></span></b></p>
              <p class="mb-1">Account Holder: <b><span id="acc_holder_popup_2"></span></b></p>

                  <p class="mb-1">PAN Copy: <b><span id="pan_popup_2"></span></b></p>
                <p class="mb-1">Bank Proof: <b><span id="bank_popup_2"></span></b></p>
                </div> -->
                <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary mb-3" style="font-size: large; color: #878a99;">Vendor Bank Details</h6>
                    <h6 style="font-size: 16px; color: #506018;"><strong><span id="bank_name_popup_2"></span></strong></h6>
                  <p class="mb-1"><i data-feather="map-pin" style="width:15px; height:15px; color:#506018"></i><span id="bank_branch_popup_2"></span></p>
                  <!-- <div class="detail-row">
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
                  </div> -->

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
                
              </div>
              <!-- Additional fields for finance approval -->
              <div class="row mt-3">
                <div class="col-md-4">
                  <label>Approved By: <span id="approver_2"></span></label>
                </div>
                <div class="col-md-4">
                  <label>Approved Date: <span id="approvedate_2"></span></label>
                </div>
                <div class="col-md-4">
                  <label>Reject Reason: <span id="financerejectreason_2"></span></label>
                </div>
              </div>
            </div>
          </div>
          <div class="row " >
                <div class="col-md-4">
                  </div>
               <div class="col-md-4" style="margin-top: -180px;">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor Invoice
                    Details</h6>
                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="ven_inv_id_2"></span></strong></h6>

                  <p class="mb-1">
                    <i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i>
                    <b><span id="ven_inv_date_2"></span></b>
                  </p>
                    <!-- <p class="mb-1">
                    <i style="width:15px; height:15px; color:#506018">Invoice Attach</i>
                    <b><span id="ven_inv_attach_2"></span></b>
                  </p> -->
                   <p class="mb-1">
                  <b>Invoice Attach: <span id="ven_inv_attach_2"></span></b>
                    </p>
                     <p class="mb-1">
             <b>PO Attach: <span id="ven_po_attach_2"></span></b>
            </p>
                </div>
              </div>
             
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <h6 class="mb-3 fw-semibold text-success" style="color: #506018 !important;"><i class="bi bi-table"></i>Vendor Bill Table</h6>
              <div class="table-responsive">
                <table id="vendor_datatable_2" class="table table-bordered table-striped table-hover align-middle">
                  <thead>
                    <tr>
                      <th style="text-align:center;">S NO</th>
                      <th style="text-align:center;">DC No</th>
                      <th style="text-align:center;">Invoice No</th>
                      <th style="text-align:center;">PO No</th>
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
                </table>
              </div>
            </div>
            <div class="row mb-6">
              <div class="col-md-12 d-flex justify-content-end align-items-center">
                <label class="fw-bold me-2 mb-0">Additional Charges:
                  <span id="add_charge" class="fw-bold text-success" style="color: #506018 !important;font-size:17px !important;">0</span>
                </label>
              </div>
              <div class="col-md-12 d-flex justify-content-end align-items-center">
                <label class="fw-bold me-2 mb-0">Total Amount:
                  <span id="ttl_span_amnt_2" class="fw-bold text-success" style="color: #506018 !important;font-size:17px !important;">0</span>
                  <input type="hidden" id="ttl_amount_2" class="form-control d-inline" readonly>
                </label>
              </div>
              
            </div>
          </div>

            <div class="table-responsive mt-4">
                <table id="vendor_bill_status"
                  class="table table-bordered table-striped table-hover align-middle">
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

              <div class="form-group row ">
                <div class="col-md-12 pt-2 pb-2" align="right">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Close</button>
                </div>
              </div>

        </div>
      </div>
    </div>
  </div>
</div>




<script>
//  document.getElementById('ven_approval_sts').addEventListener('change', function () {
//   const reasonInput = document.getElementById('reject_reason');
//   reasonInput.style.display = (this.value === '2') ? 'block' : 'none';
//   if (this.value !== '2') reasonInput.value = '';
// });
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

document.getElementById('ven_approval_sts').addEventListener('change', function() {
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



//   $(document).on('click', '.view-btn', function () {
//     var bill_no = $(this).data('bill-no');
//     var vendor = $(this).data('vendor');

//     var remark  = $(this).data('remark');

//     // alert(vendor);
//     var bill_date = $(this).data('bill-date');

//     var mail = $(this).data('vendor-mail');
//     var contact = $(this).data('vendor-mobile');
//     var address = $(this).data('vendor-address');

//     var ttl_amount = $(this).data('ttl-amount');

//     var vendor_name = $(this).data('vendor-name');

//     // Populate modal header
//     $('#bill_no').text(bill_no);
//     $('#bill_date').text(bill_date);

//     $('#mail').text(mail);
//     $('#contact').text(contact);
//     $('#address').text(address);


//     $('#vndr_name').text(vendor_name);

//  if (remark) {
//         $('#remark').val(remark); // Show the remark in the textarea
//     } else {
//         $('#remark').val(''); // If no remark, ensure the textarea is empty
//     }
//     // $('#ttl_span_amnt').text(ttl_amount);

//     // $('#ttl_span_amnt').text(Math.round(ttl_amount).toLocaleString('en-IN'));

//     $('#ttl_span_amnt').text(
//       parseFloat(ttl_amount).toLocaleString('en-IN', {
//         minimumFractionDigits: 2,
//         maximumFractionDigits: 2
//       })
//     );


//     $('#viewModal').modal('show');

//     var ajax_url = sessionStorage.getItem("folder_crud_link");


//     $.ajax({
//       url: ajax_url,
//       method: 'POST',
//       data: {
//         vendor_id: vendor,
//         action: 'bill_summary_popup'
//       },
//       success: function (response) {
//         var res = JSON.parse(response);
//         console.log(res.summary_data);
//         if (res.status && res.summary_data) {
//           $('#vendor_name_popup_1').text(res.summary_data.name || '-');
//           $('#mail_popup_1').text(res.summary_data.mail_id || '-');
//           $('#gst_no_popup_1').text(res.summary_data.gst_no || '-');
//           $('#pan_no_popup_1').text(res.summary_data.pan_no || '-');
//           $('#contact_no_popup_1').text(res.summary_data.contact_no || '-');
//           $('#address_popup_1').text(res.summary_data.address || '-');
//           $('#bank_name_popup_1').text(res.summary_data.bank_name || '-');
//           $('#bank_branch_popup_1').text(res.summary_data.branch_name || '-');
//           $('#acc_no_popup_1').text(res.summary_data.account_no || '-');
//           $('#ifsc_popup_1').text(res.summary_data.ifsc_code || '-');
//              $('#acc_holder_popup_1').text(res.summary_data.acc_holder_name || '-');
//           // $('#pan_popup_2').text(res.summary_data.pan_attach_file_name || '-');
//     if (res.summary_data.pan_attach_file_name) {
//     var fileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendor_creation/" + res.summary_data.pan_attach_file_name;
//     $('#pan_popup_1').html('<a href="' + fileUrl + '" download="' + res.summary_data.pan_attach_file_name + '">' +
//                             '<img src="uploads/vendor_creation/pdf.png" height="20px" width="20px" alt="Download PAN PDF">' +
//                           '</a>');
// } else {
//     $('#pan_popup_1').text('N/A');
// }

//   if (res.summary_data.bank_proof) {
//     var fileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendor_creation/" + res.summary_data.bank_proof;
//     $('#bank_popup_1').html('<a href="' + fileUrl + '" download="' + res.summary_data.bank_proof + '">' +
//                             '<img src="uploads/vendor_creation/pdf.png" height="20px" width="20px" alt="Download PAN PDF">' +
//                           '</a>');
// } else {
//     $('#bank_popup_1').text('N/A');
// }
//         } else {
//           alert('No vendor data found.');
//         }
//       }
//     });

//     $.ajax({
//       url: ajax_url,
//       method: 'POST',
//       data: {
//         bill_no: bill_no,
//         vendor: vendor,
//         action: 'vendor_bill_details'
//       },
//       success: function (response) {
//         var res = JSON.parse(response);

//         if (res.data && res.data.length > 0) {

//    const firstRow = res.data[0];
//           console.log(firstRow.veninvverifyid);
// console.log(firstRow.vendor_inv_attach_approval_date);


//             $('#ven_inv_id').text(firstRow.veninvverifyid || '-');
//             $('#ven_inv_date').text(firstRow.vendor_inv_attach_approval_date || '-');
          
//           let tableHtml = '';
//           res.data.forEach((row, index) => {
//             tableHtml += `
//             <tr>
//               <td>${index + 1}</td>
//               <td>${row.dc_number}</td>
//               <td>${row.invoice_no}</td>
//               <td>${row.po_num}</td>
//               <td>${row.invoice_qty}</td>
//               <td>${capitalizeWords(row.consignee_name)}</td>
//               <td>${row.rate}</td>
//               <td>${row.gst}</td>
//               <td>${row.amount}</td>
//               <td class="text-center">
//               <select class="form-select form-select-sm status-select" data-unique-id="${row.unique_id}">
//                 <option value="approved" selected>Approved</option>
//                 <option value="rejected">Reject</option>
//               </select>

//               <div class="reject-section mt-2" style="display: none;">
//                 <textarea class="form-control form-control-sm reject-reason mb-2" placeholder="Enter reason"></textarea>
//                 <div class="d-flex gap-2">
//                   <button type="button" class="btn btn-danger btn-sm confirm-reject" onclick="reject_payment(this)">Reject</button>
//                   <button type="button"  id="reject_cancel" class="btn btn-secondary btn-sm cancel-reject">Cancel</button>
//                 </div>
//               </div>
//             </td>
//             </tr>
//           `;
//           });
//           // <td>${row.dc_date}</td>

//           $('#vendor_datatable tbody').html(tableHtml);

//           $('#vendor_datatable .status-select').each(function () {
//             updateStatusColor(this);

//             // Optional: toggle reject reason section

//           });
//           // updateTotalAmount();
//         } else {
//           $('#vendor_datatable tbody').html('<tr><td colspan="9" class="text-center">No data found</td></tr>');
//         }
//       },
//       error: function () {
//         alert('Failed to fetch details');
//       }
//     });
//   });

$(document).on('click', '.view-btn', function () {

  // alert('test');
  
  var bill_no = $(this).data('bill-no');
  var vendor = $(this).data('vendor');
  var remark = $(this).data('remark');
  var bill_date = $(this).data('bill-date');
  var mail = $(this).data('vendor-mail');
  var contact = $(this).data('vendor-mobile');
  var address = $(this).data('vendor-address');
  var ttl_amount = $(this).data('ttl-amount');
  var vendor_name = $(this).data('vendor-name');
  var additional_amount = $(this).data('additional-amount');

  $('#bill_no_1').text(bill_no);
  $('#bill_date_1').text(bill_date);
  $('#mail').text(mail);
  $('#contact').text(contact);
  $('#address').text(address);
  $('#vndr_name').text(vendor_name);
  $('#remark').val(remark || '');

  $('#ttl_span_amnt_1').text('₹ ' + 
    parseFloat(ttl_amount).toLocaleString('en-IN', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    })
  );
   $('#additional_charges').text('₹ ' + 
    parseFloat(additional_amount).toLocaleString('en-IN', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    })
  );

  $('#viewModal').modal('show');

  var ajax_url = sessionStorage.getItem("folder_crud_link");

  // ✅ Fetch vendor summary
  $.ajax({
    url: ajax_url,
    method: 'POST',
    data: { vendor_id: vendor, action: 'bill_summary_popup' },
    success: function (response) {
      var res = JSON.parse(response);
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

        // if (res.summary_data.pan_attach_file_name) {
        //   var panUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendor_creation/" + res.summary_data.pan_attach_file_name;
        //   $('#pan_popup_1').html(`<a href="${panUrl}" download>
        //     <img src="uploads/vendor_creation/pdf.png" height="20px" width="20px" alt="Download PAN PDF"></a>`);
        // } else {
        //   $('#pan_popup_1').text('N/A');
        // }

        // if (res.summary_data.bank_proof) {
        //   var bankUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendor_creation/" + res.summary_data.bank_proof;
        //   $('#bank_popup_1').html(`<a href="${bankUrl}" download>
        //     <img src="uploads/vendor_creation/pdf.png" height="20px" width="20px" alt="Download Bank PDF"></a>`);
        // } else {
        //   $('#bank_popup_1').text('N/A');
        // }
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

  // ✅ Fetch bill details
  $.ajax({
    url: ajax_url,
    method: 'POST',
    data: {
      bill_no: bill_no,
      vendor: vendor,
      action: 'vendor_bill_details'
    },
    success: function (response) {

      // alert('test');
      var res = JSON.parse(response);
      if (res.data && res.data.length > 0) {
        const firstRow = res.data[0];
        $('#ven_inv_id_1').text(firstRow.veninvverifyid || '-');
        $('#ven_inv_date_1').text(firstRow.vendor_inv_attach_approval_date || '-');
        $('#remark_1').val(firstRow.bill_remark);

        $('#vendor_by').text(firstRow.bill_created_by);
         $('#vendor_date').text(firstRow.bill_crtd_date);

// if (firstRow.inv_verfiy_attach) {
//     var fileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendorpayment/" + firstRow.inv_verfiy_attach;
//     $('#ven_inv_attach_1').html('<a href="' + fileUrl + '" download="' + firstRow.inv_verfiy_attach + '">' +
//                             '<img src="uploads/vendorpayment/pdf.png" height="20px" width="20px" alt="Download PAN PDF">' +
//                           '</a>');
// } else {
//     $('#ven_inv_attach_1').text('N/A');
// }
            
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

  

if (firstRow.po_ven_filename) {
    var fileUrl = "/otm_beta/uploads/vendorpayment/PO copy/" + firstRow.po_ven_filename;
    $('#ven_po_attach_1').html(
        '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
            '<img src="uploads/vendorpayment/pdf.png" height="20px" width="20px" alt="Preview PDF">' +
        '</a>'
    );
} else {
    $('#ven_po_attach_1').text('N/A');
}


        let tableHtml = '';
        res.data.forEach((row, index) => {
          tableHtml += `
            <tr>
              <td>${index + 1}</td>
              <td data-dc-no="${row.dcno}">${row.dc_number}</td>

              <td>${row.invoice_no}</td>
              <td>${row.po_num}</td>
              <td>${row.invoice_qty}</td>
              <td>${capitalizeWords(row.consignee_name)}</td>

              <td>${row.rate}</td>
              <td style="text-align:right;">${row.basicamt || 0}</td>

              <td>${row.gst}</td>
               <td style="text-align:right;">${row.gstcamt || 0}</td>

              <td>${row.amount}</td>
              <td style="display: none;">
      <select class="form-select form-select-sm status-select" data-unique-id="${row.unique_id}" style="display:none">
        <option value="approved" selected>Approved</option>
        <option value="rejected">Reject</option>
      </select>
      <div class="reject-section mt-2" style="display: none;">
        <textarea class="form-control form-control-sm reject-reason mb-2" placeholder="Enter reason"></textarea>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-danger btn-sm confirm-reject" onclick="reject_payment(this)">Reject</button>
          <button type="button" class="btn btn-secondary btn-sm cancel-reject">Cancel</button>
        </div>
      </div>
    </td>
            </tr>
          `;
        });

        $('#vendor_datatable_1 tbody').html(tableHtml);
        $('#vendor_datatable_1 .status-select').each(function () {
          updateStatusColor(this);
        });
      } else {
        $('#vendor_datatable_1 tbody').html('<tr><td colspan="9" class="text-center">No data found</td></tr>');
      }
    },
    error: function () {
      alert('Failed to fetch details');
    }
  });
});

              // <td>${row.dc_number}</td>
// 
  // $(document).on('click', '.view-btn-2', function () {
  //   // var bill_no = $(this).data('bill-no');
  //   var vendor = $(this).data('vendor');
  //   var bill_no = $(this).data('billno');
  //   var bill_date = $(this).data('billdate');
  //   var approver = $(this).data('approver');
  //   var approvedate = $(this).data('approvedate');
  //   var financeapproval = $(this).data('financeapproval');
  //   var financerejectreason = $(this).data('financerejectreason');

  //   $('#bill_no_2').text(bill_no);
  //   $('#bill_date_2').text(bill_date);
  //   $('#approver_1').text(approver);
  //   $('#approvedate_1').text(approvedate);
  //   $('#approver_2').text(approver);
  //   $('#approvedate_2').text(approvedate);
  //   $('#financerejectreason_2').text(financerejectreason);
  //    if (financeapproval == 2) {
  //     // Rejected
  //     $('#reject-div').show();
  //     $('#approve-div').hide();
  //   } else if (financeapproval == 1) {
  //     // Approved
  //     $('#approve-div').show();
  //     $('#reject-div').hide();
  //   } else {
  //     // Neither approved nor rejected – optional case
  //     $('#approve-div').hide();
  //     $('#reject-div').hide();
  //   }


  //   $('#viewModal-2').modal('show');

  //   var ajax_url = sessionStorage.getItem("folder_crud_link");

  //   $.ajax({
  //     url: ajax_url,
  //     method: 'POST',
  //     data: {
  //       vendor_id: vendor,
  //       action: 'bill_summary_popup'
  //     },
  //     success: function (response) {
  //       var res = JSON.parse(response);
  //       console.log(res.summary_data);
  //       if (res.status && res.summary_data) {
  //         $('#vendor_name_popup_2').text(res.summary_data.name || '-');
  //         $('#mail_popup_2').text(res.summary_data.mail_id || '-');
  //         $('#gst_no_popup_2').text(res.summary_data.gst_no || '-');
  //         $('#pan_no_popup_2').text(res.summary_data.pan_no || '-');
  //         $('#contact_no_popup_2').text(res.summary_data.contact_no || '-');
  //         $('#address_popup_2').text(res.summary_data.address || '-');
  //         $('#bank_name_popup_2').text(res.summary_data.bank_name || '-');
  //         $('#bank_branch_popup_2').text(res.summary_data.branch_name || '-');
  //         $('#acc_no_popup_2').text(res.summary_data.account_no || '-');
  //         $('#ifsc_popup_2').text(res.summary_data.ifsc_code || '-');
  //            $('#acc_holder_popup_2').text(res.summary_data.acc_holder_name || '-');

  //         // $('#pan_popup_2').text(res.summary_data.pan_attach_file_name || '-');
  //         // $('#bank_popup_2').text(res.summary_data.bank_proof || '-');
  //         // For the PAN attachment (Click to download PDF)
  //         if (res.summary_data.pan_attach_file_name) {
  //             var fileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendor_creation/" + res.summary_data.pan_attach_file_name;
  //             $('#pan_popup_2').html('<a href="' + fileUrl + '" download="' + res.summary_data.pan_attach_file_name + '">' +
  //                                     '<img src="uploads/vendor_creation/pdf.png" height="20px" width="20px" alt="Download PAN PDF">' +
  //                                   '</a>');
  //         } else {
  //             $('#pan_popup_2').text('N/A');
  //         }

  //           if (res.summary_data.bank_proof) {
  //             var fileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendor_creation/" + res.summary_data.bank_proof;
  //             $('#bank_popup_2').html('<a href="' + fileUrl + '" download="' + res.summary_data.bank_proof + '">' +
  //                                     '<img src="uploads/vendor_creation/pdf.png" height="20px" width="20px" alt="Download PAN PDF">' +
  //                                   '</a>');
  //         } else {
  //             $('#bank_popup_2').text('N/A');
  //         }
  //                 } else {
  //                   alert('No vendor data found.');
  //                 }
  //               }
  //             });

  //             $.ajax({
  //               url: ajax_url,
  //               method: 'POST',
  //               data: {
  //                 bill_no: bill_no,
  //                 vendor: vendor,
  //                 financeapproval: financeapproval,
  //                 action: 'vendor_bill_details_popup'
  //               },
  //               success: function (response) {
  //                 var res = JSON.parse(response);

  //                 if (res.data && res.data.length > 0) {
  //                 const firstRow = res.data[0];

  //                 // ✅ Display approval ID and date
  //                 $('#ven_inv_id').text(firstRow.veninvverifyid || '-');
  //                 $('#ven_inv_date').text(firstRow.vendor_inv_attach_approval_date || '-');

  //                 console.log("Vendor Approval ID:", firstRow.veninvverifyid);
  //                 console.log("Vendor Approval Date:", firstRow.vendor_inv_attach_approval_date);

  //                   console.log(res.data);
  //                   let tableHtml = '';
  //                   let ttl_amount = 0;

  //                   res.data.forEach((row, index) => {
  //                     // Remove commas and convert amount to number
  //                     let cleanAmount = parseFloat((row.sum_amount || '0').toString().replace(/,/g, '')) || 0;
  //                     ttl_amount += cleanAmount;

  //                     tableHtml += `
  //               <tr>
  //                 <td>${index + 1}</td>
  //                 <td>${row.dc_num}</td>
  //                 <td>${row.invoice_no}</td>
  //                 <td>${row.po_num}</td>
  //                 <td>${row.invoice_qty}</td>
  //                 <td>${row.consignee_name}</td>
  //                 <td>${row.rate}</td>
  //                 <td>${row.gst}</td>
  //                 <td>${row.amount}</td>
  //               </tr>
  //             `;
  //                   });

  //                   $('#vendor_datatable_popup tbody').html(tableHtml);

  //                   // Format total with 2 decimals, Indian format
  //                   const formattedTotal = parseFloat(ttl_amount).toLocaleString('en-IN', {
  //                     minimumFractionDigits: 2,
  //                     maximumFractionDigits: 2
  //                   });

  //                   $('#ttl_span_amnt_2').text('₹ ' + formattedTotal);
  //                   $('#ttl_span_amnt_3').text('₹ ' + formattedTotal);

  //                 } else {
  //                   $('#vendor_datatable_popup tbody').html('<tr><td colspan="9" class="text-center">No data found</td></tr>');
  //                   $('#ttl_span_amnt_2').text('₹ 0.00');
  //                   $('#ttl_span_amnt_3').text('₹ 0.00');
  //                 }
  //               },
  //               error: function () {
  //                 alert('Failed to fetch details');
  //               }
  //             });
  //  });

$(document).on('click', '.view-btn-2', function () {

  // alert('2');
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

  if (financeapproval == 2) {
    $('#reject-div').show();
    $('#approve-div').hide();
  } else if (financeapproval == 1) {
    $('#approve-div').show();
    $('#reject-div').hide();
  } else {
    $('#approve-div').hide();
    $('#reject-div').hide();
  }

  $('#viewModal-2').modal('show');

  var ajax_url = sessionStorage.getItem("folder_crud_link");

  // ✅ Fetch vendor summary
  $.ajax({
    url: ajax_url,
    method: 'POST',
    data: { vendor_id: vendor, action: 'bill_summary_popup' },
    success: function (response) {
      var res = JSON.parse(response);
      if (res.status && res.summary_data) {
        $('#vendor_name_popup_2').text(res.summary_data.name || '-');
        $('#vendor_comname_popup_2').text(res.summary_data.company_name || '-');
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


                // For the PAN attachment (Click to download PDF)
// PAN File
if (res.summary_data.pan_attach_file_name) {
    var fileUrl = "/otm_beta/uploads/vendor_creation/" + res.summary_data.pan_attach_file_name;
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
    var fileUrl = "/otm_beta/uploads/vendor_creation/" + res.summary_data.bank_proof;
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

  // ✅ Fetch bill details
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
        const firstRow = res.data[0];
      
  

  $('#ven_inv_id_2').text(firstRow.veninvverifyid || '-');
        $('#ven_inv_date_2').text(firstRow.vendor_inv_attach_approval_date || '-');
        // $('#remark_1').text(firstRow.bill_remark || '-');

      // $('#invoice_no').text(firstRow.invoice_no || 'N/A');
if (firstRow.inv_verfiy_attach) {
    var fileUrl = "/otm_beta/uploads/vendorpayment/" + firstRow.inv_verfiy_attach;
    $('#ven_inv_attach_2').html(
        '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
            '<img src="uploads/vendorpayment/pdf.png" height="20px" width="20px" alt="Preview PDF">' +
        '</a>'
    );
} else {
    $('#ven_inv_attach_2').text('N/A');
}


if (firstRow.po_ven_filename) {
    var fileUrl = "/otm_beta/uploads/vendorpayment/PO copy/" + firstRow.po_ven_filename;
    $('#ven_po_attach_2').html(
        '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
            '<img src="uploads/vendorpayment/pdf.png" height="20px" width="20px" alt="Preview PDF">' +
        '</a>'
    );
} else {
    $('#ven_po_attach_2').text('N/A');
}

        let tableHtml = '';
        let ttl_amount = 0;
 let total_amount = parseFloat((firstRow.total_amount || '0').toString().replace(/,/g, '')) || 0;
        let additional_amount = parseFloat((firstRow.additional_amount || '0').toString().replace(/,/g, '')) || 0;

        res.data.forEach((row, index) => {
          
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
      <td style="text-align:right;">${row.basicamt || 0}</td>

              <td>${row.gst}</td>
      <td style="text-align:right;">${row.gstcamt || 0}</td>

              <td>${row.amount}</td>
            </tr>`;
        });

        $('#vendor_datatable_2 tbody').html(tableHtml);

        const formattedTotal = parseFloat(total_amount).toLocaleString('en-IN', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });

        const formattedadditional = parseFloat(additional_amount).toLocaleString('en-IN', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });

        $('#add_charge').text('₹ ' + formattedadditional);
        $('#ttl_span_amnt_2').text('₹ ' + formattedTotal);
        $('#ttl_span_amnt_3').text('₹ ' + formattedTotal);
      } else {
        $('#vendor_datatable_2 tbody').html('<tr><td colspan="9" class="text-center">No data found</td></tr>');
        $('#ttl_span_amnt_2').text('₹ 0.00');
        $('#ttl_span_amnt_3').text('₹ 0.00');
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


  // function reject_btn(selected_status) {

  //   if (selected_status === 'rejected') {
  //     reject_reason = row.find('.reject-reason').val() || '';
  //     row.find('.status-select').replaceWith('<span class="text-danger fw-bold">Rejected</span>');
  //     row.find('.reject-section').hide();
  //   } else {
  //     row.find('.status-select').replaceWith('<span class="text-success fw-bold">Approved</span>');
  //   }
  // }


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

  $('#vendor_datatable_1').on('change', '.status-select', function () {
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



  function update_remark(){

            var remark = $('#remark_1').val();
            // alert(remark);

            var bill_no = $('#bill_no_1').text();

            var ajax_url = sessionStorage.getItem("folder_crud_link");

            var url = sessionStorage.getItem("list_link");

            var data = {
                remark :remark,
                bill_no:bill_no,
                "action":'update_remark'
            };

            $.ajax({
                url:ajax_url,
                type:'POST',
                data:data,

                success:function(data){
                  
                let res = JSON.parse(data);
                if (res.status == 1) {
                    // sweetalert(res.msg,url);
                } else {
                    alert("Error: " + res.msg);
                    console.log(res.error, res.sql);
                }
              }


    });
}

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


// function reject_payment(button) {
//   const row = $(button).closest('tr');
//   const selected_status = row.find('.status-select').val();
//   const dc_no_with_date = row.find('td').eq(1).text().trim();
//   const unique_id = row.find('.status-select').attr('data-unique-id');
//   const reject_reason = row.find('.reject-reason').val() || '';

//   if (!reject_reason) {
//     alert("Please enter a rejection reason.");
//     return; // Prevent submission
//   }

//   // Optional confirmation
//   if (!confirm("Are you sure you want to reject this payment?")) {
//     return;
//   }

//   const parts = dc_no_with_date.split(/\s+/);
//   const dc_no = parts[0];
//   const ajax_url = sessionStorage.getItem("folder_crud_link");
//   const bill_no = $('#bill_no_1').text();

//   // Update UI immediately
//   row.find('.status-select').replaceWith('<span class="text-danger fw-bold">Rejected</span>');
//   row.find('.reject-section').hide();

//   $.ajax({
//     type: 'POST',
//     url: ajax_url,
//     data: {
//       dc_no: dc_no,
//       bill_no: bill_no,
//       unique_id: unique_id,
//       finance_approval_sts: '2',
//       reject_reason: reject_reason,
//       action: 'vendor_bill_approval'
//     },
//     success: function (response) {
//       console.log("Rejected successfully");

//       let res = typeof response === 'string' ? JSON.parse(response) : response;

//       if (res.total_amount) {
//         let roundedAmount = Math.round(res.total_amount);
//         let formattedAmount = roundedAmount.toLocaleString('en-IN');
//         $('#ttl_span_amnt').text(formattedAmount);
//       }
//     },
//     error: function () {
//       alert("Error rejecting entry");
//     }
//   });
// // }
// function reject_payment(button) {
//   const row = $(button).closest('tr');
//   const selected_status = row.find('.status-select').val();
//   const dc_no_with_date = row.find('td').eq(1).text().trim();
//   const unique_id = row.find('.status-select').attr('data-unique-id');
//   const reject_reason = row.find('.reject-reason').val() || '';

//   if (!reject_reason) {
//     Swal.fire({
//       icon: 'error',
//       title: 'Missing Reason',
//       text: 'Please enter a rejection reason.',
//     });
//     return;
//   }

//   Swal.fire({
//     title: 'Are you sure?',
//     text: 'Do you really want to reject this payment?',
//     icon: 'warning',
//     showCancelButton: true,
//     confirmButtonColor: '#d33',
//     cancelButtonColor: '#3085d6',
//     confirmButtonText: 'Yes, reject it',
//     cancelButtonText: 'Cancel'
//   }).then((result) => {
//     if (!result.isConfirmed) return;

//     // ✅ Proceed only if confirmed
//     const parts = dc_no_with_date.split(/\s+/);
//     const dc_no = parts[0];
//     const ajax_url = sessionStorage.getItem("folder_crud_link");
//     const bill_no = $('#bill_no_1').text();

//     // Update UI immediately
//     row.find('.status-select').replaceWith('<span class="text-danger fw-bold">Rejected</span>');
//     row.find('.reject-section').hide();

//     $.ajax({
//       type: 'POST',
//       url: ajax_url,
//       data: {
//         dc_no: dc_no,
//         bill_no: bill_no,
//         unique_id: unique_id,
//         finance_approval_sts: '2',
//         reject_reason: reject_reason,
//         action: 'vendor_bill_approval'
//       },
//       success: function (response) {
//         console.log("Rejected successfully");

//         let res = typeof response === 'string' ? JSON.parse(response) : response;

//         if (res.total_amount) {
//           let roundedAmount = Math.round(res.total_amount);
//           let formattedAmount = roundedAmount.toLocaleString('en-IN');
//           $('#ttl_span_amnt').text(formattedAmount);
//         }

//         // Optional: show success toast
//         Swal.fire({
//           icon: 'success',
//           title: 'Rejected',
//           text: 'The payment has been rejected successfully.'
//         });
//       },
//       error: function () {
//         Swal.fire({
//           icon: 'error',
//           title: 'Error',
//           text: 'Something went wrong while rejecting the payment.'
//         });
//       }
//     });
//   });
// }
// function vendor_payment() {
//     $('#apprvl_btn').show();

//     var ajax_url = sessionStorage.getItem("folder_crud_link");
//     var bill_no = $('#bill_no_1').text();
//     var url = sessionStorage.getItem("list_link");

//     var reject_reason = $('#reject_reason').val().trim();
//     var ven_approval_sts = $('#ven_approval_sts').val();

//     // 🔴 Validation before looping
//     if (ven_approval_sts === '2' && reject_reason === '') {
//         Swal.fire({
//             icon: 'warning',
//             title: 'Reject Reason Required',
//             text: 'Please enter the reject reason before proceeding.',
//             confirmButtonColor: '#3085d6',
//             confirmButtonText: 'OK'
//         }).then(() => {
//             $('#reject_reason').focus();
//         });
//         return; // ✅ Stop entire function here
//     }

//     // ✅ Proceed only if validation passes
//     $('#vendor_datatable_1 tbody tr').each(function () {
//         var row = $(this);

//         var selected_status = row.find('.status-select').val();
//         var fullText = row.find('td').eq(1).text().trim();
//         var dc_no = fullText.match(/DC\S+/)?.[0] || '';
//         var unique_id = row.find('.status-select').attr('data-unique-id');

//         if (!unique_id) {
//             console.warn('Missing unique_id for DC:', dc_no);
//             return; // skip this row
//         }

//         let data = {
//             dc_no: dc_no,
//             bill_no: bill_no,
//             unique_id: unique_id,
//             ven_approval_sts: ven_approval_sts,
//             reject_reason: reject_reason,
//             action: "vendor_bill_approval"
//         };

//         console.log('Sending Data:', data);

//         $.ajax({
//             type: "POST",
//             url: ajax_url,
//             data: data,
//             success: function (response) {
//                 console.log(`Status Updated for DC ${dc_no} | Status: ${selected_status}`);
//             },
//             error: function () {
//                 alert(`Network error for DC ${dc_no}`);
//             }
//         });
//     });

//     // ✅ Redirect after a small delay
//     setTimeout(function () {
//         sweetalert('create', url);
//     }, 1000);
// }

function removeRedBorder(textarea) {
    textarea.style.border = '1px solid #ced4da'; // reset border
    document.getElementById('remarkError').style.display = 'none';
}

function vendor_payment() {

    $('#apprvl_btn').show();

    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var bill_no = $('#bill_no_1').text();
    var url = sessionStorage.getItem("list_link");

    var reject_reason = $('#reject_reason').val().trim();
    var ven_approval_sts = $('#ven_approval_sts').val();

    // 🔴 Validation: If Rejected, reject_reason is required
    if (ven_approval_sts === '2' && reject_reason === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Reject Reason Required',
            text: 'Please enter the reject reason before submitting.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then(() => {
            $('#reject_reason').focus();
            $('#reject_reason').css('border', '1px solid red'); // show red border
            document.getElementById('remarkError').style.display = 'inline';
        });
        return false; // stop execution
    }

    var hasError = false;

    $('#vendor_datatable_1 tbody tr').each(function () {
        var row = $(this);

        var selected_status = row.find('.status-select').val();
        var fullText = row.find('td').eq(1).text().trim();
        // var dc_no = fullText.match(/DC\S+/)?.[0] || '';
         var dc_no = row.find('td').eq(1).data('dc-no'); // ✅ correct DC
        // alert(dc_no);
        var unique_id = row.find('.status-select').attr('data-unique-id');

        if (!unique_id) {
            console.warn('Missing unique_id for DC:', dc_no);
            hasError = true;
            return;
        }

        let data = {
            dc_no: dc_no,
            bill_no: bill_no,
            unique_id: unique_id,
            ven_approval_sts: ven_approval_sts,
            reject_reason: reject_reason,
            action: "vendor_bill_approval"
        };

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            async: false, 
            success: function (response) {
                console.log(`Status Updated for DC ${dc_no} | Status: ${selected_status}`);
            },
            error: function () {
                hasError = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `Network error while updating DC ${dc_no}`
                });
            }
        });
    });

    if (!hasError) {
        setTimeout(function () {
            sweetalert('create', url);
        }, 500);
    }
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
