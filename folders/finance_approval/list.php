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

  /* General table cell styling */
#vendorpayment_datatable_completed td,
#vendorpayment_datatable_completed th {
  padding: 6px 8px !important;
  vertical-align: middle;
  white-space: nowrap;
  font-size: 13px;
}

/* Amount column only (4th column) - compact and aligned */
/* #vendorpayment_datatable_completed td:nth-child(4),
#vendorpayment_datatable_completed th:nth-child(4) {
  padding: 4px 6px !important;
  text-align: right;
  width: 90px;
  font-size: 13px;
} */
/* Target the 4th column: "Amount" */
#vendorpayment_datatable_completed td:nth-child(4),
#vendorpayment_datatable_completed th:nth-child(4) {
  text-align: left;
  /* padding: 12px 12px !important; */
  min-width: auto !important;
  /* width: 100px !important;       or try 60px, adjust as needed */
  /* max-width: 90px !important; */
  width: 100px;
  font-size: 13px;
  white-space: nowrap;
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
      <h4 class="mb-sm-0">Accounts Team Bill Approval</h4>
      <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
        value="<?php echo $screen_id_val; ?>">
      <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
        value="<?php echo $user_type_unique_id; ?>">

      <div class="page-title-right">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="javascript: void(0);">Vendor Payment</a></li>
          <li class="breadcrumb-item active">Accounts Team Bill Approval</li>
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
            <span class="d-none d-sm-block">Accounts Team Bill Approval Pending</span>
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
                  class=" pt-2 table table-bordered nowrap table-striped align-middle">
                  <thead>
                    <tr>
                      <th style="text-align:center;">S.No</th>
                          <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Bill Date / Bill No</th>
                            <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Invoice Date / Invoice No</th>
                      <!-- <th style="text-align:center;">Bill No</th> -->
                      <th style="text-align:center;">Vendor Name</th>
                        <th style="text-align:center; white-space: nowrap; width: 80px;">Dc Count</th>
                      <th style="text-align:center;">Amount</th>
                       <th style="text-align:center;">Advance Amount</th>
                        <th style="text-align:center;">Total Payble Amount</th>
                         <th style="text-align:center;">Vendor Approved By/ Date</th>
                        <th style="text-align:center;">Status</th>
                         <th style="text-align:center;">Reject Reason</th>
                          <th style="text-align:center;">Rejected By</th>

                      <th style="text-align:center;">Remarks</th>
      <!-- <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Bill Approveby /Date</th> -->
                      
                      <th style="text-align:center;">Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
       <div class="tab-pane" id="arrow-contact" role="tabpanel">
  <div class="table-responsive">
    <table id="vendorpayment_datatable_completed" class="table table-bordered table-striped align-middle">
      <thead>
        <tr>
          <th style="text-align:center;">S.No</th>
          <!-- <th style="text-align:center;">Bill No / Bill Date</th> -->
           <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Bill Date / Bill No</th>
              <th style="text-align:center; white-space: nowrap; width: 150px;">Vendor Invoice Date / Invoice No</th>
          <th style="text-align:center;">Vendor Name</th>
                        <th style="text-align:center; white-space: nowrap; width: 80px;">Dc Count</th>

          <th style="text-align:center;">Amount</th>
          <th style="text-align: right;">Tds Deduction</th>
          <th style="text-align: right;">other Deduction</th>
            <th style="text-align:center;">Advance Amount</th>
          <th style="text-align:right;">Total Payable Amount</th>
          <th style="text-align:center;">Accounts Team Approved By / Date</th>
          <th style="text-align:center;">Status</th>
          <th style="text-align:center;">Action</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
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
        <h5 class="modal-title fw-bold text-center w-100" style="color: #506018 !important;" id="viewModalLabel">Accounts
          Team Bill Approval</h5>
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


                  
                    <h6 class="text-uppercase text-body-primary mt-4 mb-3" style="font-size: large; color: #878a99;">Vendor Bill Approval Details</h6>
                  <h6 style="font-size: 16px; color: #506018;">Bill created By </h6><strong><span id="vendor_bill_created"></span></strong>
                  <h6 style="font-size: 16px; color: #506018;">Bill Approved By </h6><strong><span id="vendor_bill_approved"></span></strong>
                   <h6 style="font-size: 16px; color: #506018;">Account Bill created By </h6><strong><span id="acc_bill"></span></strong></h6>
                   <h6 style="font-size: 16px; color: #506018;">Account Remarks </h6><strong><span id="accdetuctionremarks"></span></strong></h6>
                  <!-- <p class="mb-1">Bill Date<i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i> <b><span id="ven_approval_date_1"></span></b></p> -->
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
                  <!-- <p class="mb-1">
                    Account No: <b><span id="acc_no_popup_1"></span></b>
                  </p>
                  <p class="mb-1">
                    IFSC Code: <b><span id="ifsc_popup_1"></span></b>
                  </p> -->
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
              <!-- <div class="row">
                   <div class="col-md-4"></div>
               <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor Accounts Bill Details
                    </h6>
                  <p class="mb-1">
                    <i  style="width:15px; height:15px; color:#506018"></i>
                     <h6 style="font-size: 16px; color: #506018;"><strong><span id="accountbillid1"></span></strong></h6>
                  </p>
                  <p class="mb-1">
                    
                  TDS Deduction:: <b><span id="tds_value_detuction1"></span></b>
                  </p>
                  <p class="mb-1">
                   Others Detuction: <b><span id="othersval1"></span></b>
                  </p>
                   <p class="mb-1">
                  Total Payble Amount: <b><span id="tot_payamount1"></span></b>
                  </p>
                </div>
              </div> -->

            </div>
          </div>
            <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="margin-top: -150px;">
              <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor Invoice Details</h6>
              <h6 style="font-size: 16px; color: #506018;"><strong><span id="ven_inv_id_1"></span></strong></h6>
              <p class="mb-1">
                <i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i>
                <b><span id="ven_inv_date_1"></span></b>
              </p>
               
                      <p class="mb-1">
                  <b>Invoice Attach: <span id="ven_inv_attach_1"></span></b>
                    </p>
                    <p class="mb-1">
                  <b>PO Attach: <span id="ven_po_attach_1"></span></b>
                    </p>
            </div>
          </div>
          

          <input type="hidden" name="po_num" id="po_num">
          <input type="hidden" id="hidden_dc" name="hidden_dc">
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
                        <th style="text-align:center;">Consignee Address</th>
                       <th style="text-align:center;">Unit Price</th>
                        <th style="text-align:center;">Basic amount</th>
                        <th style="text-align:center;">GST</th>
                        <th style="text-align:center;">GsT Amount</th>
                        <th style="text-align:center;">Total Amount</th>
                        <!-- <th style="text-align:center;">Status</th> -->
                      </tr>
                    </thead>
                  </tbody>
<tfoot>
<tr>
    <th colspan="6" style="text-align:right;">Total</th>
    <th id="sum_rate" style="text-align:right;"></th>
    <th id="sum_basic" style="text-align:right;"></th>
    <th></th>
    <th id="sum_gst_amt" style="text-align:right;"></th>
    <th id="sum_total" style="text-align:right;"></th>
</tr>
</tfoot>
                </table>
              </div>
            </div>

                  <!-- <div class="row" id="remarks_div">
    <div class="col-md-4 d-flex align-items-center">
        <div class="me-2 w-100">
           
                    <label class="form-label">Remarks</label>
                    <textarea class="form-control" id="remark" name="remark" rows="4" oninput="validateremark(this)"><?php echo $dc_ir_remarks; ?></textarea>
            </div>
            <button type="button" class="btn btn-primary mt-4 ms-3" onclick="update_remark()">Update</button>
</div>
</div>

         
       <input type="hidden" id="sess_id" name="sess_id" value="<?php echo $user_type_unique_id; ?>">
          <div class="row mb-4">
            <div class="col-md-12 d-flex flex-column align-items-end text-end">
             
              <label class="fw-bold mb-2">Total Amount: ₹
                <span id="ttl_span_amnt" class="fw-bold text-success"
                  style="color: #506018 !important; font-size:17px !important;">0</span>
                <input type="hidden" id="ttl_amount" readonly>
              </label>

             
              <p class="mb-1" style="color:#506018; font-weight: 600;display:none" >
                Account Bill ID: <span id="accountbillid1"></span>
              </p>

             
              <p class="mb-1" style="color:#506018;">
                TDS Deduction: <b><span id="tds_value_detuction1"></span></b>
              </p>

             
              <p class="mb-1" style="color:#506018;">
                Others Deduction: <b><span id="othersval1"></span></b>
              </p>

             
              <p class="mb-1" style="color:#506018;">
                Total Payable Amount: <b><span id="tot_payamount1"></span></b>
              </p>

        </div>
      </div>
 -->
  <div class="container-fluid px-3">
  <!-- Row 1: Remarks + Update Button -->
  <div class="row mt-3 align-items-start">
    <div class="col-md-6">
      <label for="remark" class="form-label fw-semibold">Remarks:</label>
      <div class="d-flex align-items-start">
        <textarea 
          class="form-control me-2" 
          id="remark" 
          name="remark" 
          rows="4" 
          oninput="validateremark(this)" 
          style="resize: none;"
        ><?php echo $dc_ir_remarks; ?></textarea>
        
        <button 
          type="button" 
          class="btn btn-success mt-4" 
          style="height: 40px; white-space: nowrap; margin-top: 3px;"
          onclick="update_remark()"
        >
          Update
        </button>
      </div>
    </div>

    <!-- Amount Summary Section -->
    <div class="col-md-6 d-flex flex-column align-items-end mt-2">
      <div class="w-100" style="max-width: 300px;">
        <div class="d-flex justify-content-between mb-1">
          <span>Total Amount:</span>
          <span id="ttl_span_amnt" class="fw-bold" style="font-size: 16px;"></span>
          <input type="hidden" id="ttl_amount" readonly>
        </div>
         <div class="d-flex justify-content-between mb-1">
          <span>Additional Charges:</span>
          <span id="add_charge2" style="font-size: 15px;"></span>
        </div>
        <div class="d-flex justify-content-between mb-1">
          <span>TDS Deduction:</span>
          <span id="tds_value_detuction1" style="font-size: 15px;"></span>
        </div>
        <div class="d-flex justify-content-between mb-1">
          <span>Others Deduction:</span>
          <span id="othersval1" style="font-size: 15px;"></span>
        </div>
          <div class="d-flex justify-content-between">
          <span>Advance Amount:</span>
          <span id="advanceamount1" class="fw-bold" style="font-size: 16px;color:#506018"></span>
        </div>
        <!-- <div class="d-flex justify-content-between">
          <span>Additional Charges:</span>
          <span id="add_charge" class="fw-bold" style="font-size: 16px;color:#506018"></span>
        </div> -->
        <hr class="my-2">
        <div class="d-flex justify-content-between">
          <span>Total Payable Amount:</span>
          <span id="tot_payamount1" class="fw-bold" style="font-size: 16px;"></span>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4 align-items-start g-3">

    <!-- Status -->
    <div class="col-md-4">
        <label class="form-label fw-semibold">Status:</label>
        <select class="form-select"
                id="ven_approval_sts"
                name="ven_approval_sts">
            <option value="1" selected>Approved</option>
            <option value="2">Reject</option>
        </select>
    </div>

    <!-- Previous Stage -->
    <div class="col-md-4 d-none" id="prev_stage_div">
        <label class="form-label fw-semibold">Stages:<span class="text-danger">*</span></label>
        <select class="form-select"
                id="prev_stage"
                name="prev_stage">
                <option value="">Select Previous Stages</option>  
            <!-- <option value="1">Vendor Bill Creation</option> -->
            <option value="2">Accounts Team Entry</option>
        </select>
    </div>

    <!-- Reject Reason -->
    <div class="col-md-4 d-none" id="rejectlabel">
        <label class="form-label fw-semibold">
            Reject Reason <span class="text-danger">*</span>
        </label>
        <textarea
            class="form-control"
            id="reject_reason"
            name="reject_reason"
            rows="3"
            placeholder="Enter reject reason"
            oninput="validateremark(this);removeRedBorder(this)"
            style="resize: none;">
        </textarea>
        <small id="remarkError" class="text-danger d-none">
            This field is required
        </small>
    </div>

</div>


  <!-- Row 2: Status + Reject Reason -->
  <!-- <div class="row mt-4 align-items-start">
    <div class="col-md-3">
      <label class="form-label fw-semibold">Status:</label>
      <select class="form-select"  id="ven_approval_sts"  name="ven_approval_sts"  style="width: 400px;" onchange="get_prev_stage()">
        <option value="1" selected>Approved</option>
        <option value="2">Reject</option>
      </select>
    </div>


    <div class="col-md-3" id="prev_stage_div" style="display: none;">
      <label class="form-label fw-semibold">Stages:</label>
      <select class="form-select"  id="prev_stage"  name="prev_stage"  style="width: 400px;" >
        <option value="vendor_bill">Vendor Bill Creation</option>
        <option value="acc_team_entry">Accounts Team Entry</option>
      </select>
    </div>

    <div class="col-md-3" id="rejectlabel" style="display: none;margin-left: -87px;" >
      <label class="form-label fw-semibold">Reject Reason:<span class="text-danger">*</span></label>
      <textarea 
        class="form-control" 
        id="reject_reason" 
        name="reject_reason"  
        rows="3"  oninput="validateremark(this);removeRedBorder(this)"
        placeholder="Enter reject reason"
        style="resize: none; display: none;" 
      ></textarea>
      <small id="remarkError" class="text-danger" style="display: none;">This field is required</small>
    </div>
  </div> -->

<!-- Buttons aligned right -->
<div class="row mt-3">
  <div class="col-12 d-flex justify-content-end gap-2">
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
      <i class="bi bi-x-circle"></i> Close
    </button>
    <button type="button" class="btn btn-success" id="apprvl_btn" onclick="vendor_payment()">
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
</div>

<div class="modal fade" id="viewModal-2" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog custom-wide-modal modal-dialog-centered modal-dialog-scrollable">

    <div class="modal-content shadow-lg rounded-4 border-0">
      <!-- <div class="modal-header bg-success text-white rounded-top"> -->
      <div class="modal-header"
        style="background-color: #d6d8b3; color: #506018 !important; font-weight: bold; border-top-left-radius: 0.3rem; border-top-right-radius: 0.3rem; padding: 0.8rem !important;">
        <h5 class="modal-title fw-bold text-center w-100" style="color: #506018 !important;" id="viewModalLabel">Account Team Approval
         </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" id="viewModalBody" style="background-color: #f9fafb;">
        <div class="container-fluid">

          <!-- DC Details Card -->
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">

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
                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="bill_no_2"></span></strong></h6>

                  <p class="mb-1">
                    <i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i>
                    <b><span id="bill_date_2"></span></b>
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
 <!-- <div class="col-md-4" style="margin-top: -50px;">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Vendor Accounts Bill Entry
                    Details</h6>
                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="billentryname"></span></strong></h6>

                  <p class="mb-1">
                    <i data-feather="calendar" style="width:15px; height:15px; color:#506018"></i>
                    <b><span id="billentrydate"></span></b>
                  </p>
                </div>
            </div> -->
            
            <!-- <di
             v class="row">
            <div class="col-md-4"></div>
              <div class="col-md-4">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;margin-top:-100px">Vendor Account
                    Details</h6>
                
                  <h6 style="font-size: 16px; color: #506018;"><strong><span id="accountbillidcom"></span></strong>
                  </h6>

                  <p class="mb-1">
                  TDS Deduction: <i  style="width:15px; height:15px; color:#506018"></i>
                    <span id="tds_value_detuctioncom"></span>
                  </p>
                  <p class="mb-1">
                   Others Detuction: <b><span id="othersvalcom"></span></b>
                  </p>
                  <p class="mb-1">
                    Total Payble Amount: <b><span id="tot_payamountcom"></span></b>
                  </p>
                </div>
              </div>
          </div> -->
            <div class="row " >
                <div class="col-md-4">
                  </div>
               <div class="col-md-4" style="margin-top: -120px;">
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
                        <!-- <th style="text-align:center;">Consignee Name</th> -->
                        <th style="text-align:center;">Consignee Address</th>

                       <th style="text-align:center;">Unit Price</th>
                        <th style="text-align:center;">Basic amount</th>
                        <th style="text-align:center;">GST</th>
                        <th style="text-align:center;">GsT Amount</th>
                        <th style="text-align:center;">Total Amount</th>
                        <!-- <th style="text-align:center;">Status</th> -->
                      </tr>
                    </thead>
                  </tbody>
<tfoot>
        <tr>
            <th colspan="6" style="text-align:right;">Total</th>
            <th id="popup_sum_rate" style="text-align:right;"></th>
            <th id="popup_sum_basic" style="text-align:right;"></th>
            <th></th>
            <th id="popup_sum_gst_amt" style="text-align:right;"></th>
            <th id="popup_sum_total" style="text-align:right;"></th>
        </tr>
    </tfoot>
                </table>
              </div>
            </div>
            <input type="hidden" id="sess_id" name="sess_id" value="<?php echo $user_type_unique_id; ?>">

           <div class="row mt-2" style="margin:0 15px;" id="approve-div">
  <!-- Left Column: Approval Info -->
  <div class="col-md-6">
    <!-- Approved By & Date -->
    <div class="mb-2 d-flex flex-wrap">
      <label class="me-3 mb-0">Accounts Team Bill approved By:
        <span id="approver_1" class="fw-bold text-success" style="color: #506018 !important; font-size:15px !important;">Prabu</span>
      </label>
      <label class="mb-0">Accounts  TeamBill approved Date:
        <span id="approvedate_1" class="fw-bold text-success" style="color: #506018 !important; font-size:15px !important;">13-10-2025</span>
      </label>
    </div>

    <!-- Account ID -->
    <div class="mb-2" style="display:none">
      <label class="mb-0">Account Id:
        <span id="accountbillidcom" class="fw-bold text-success" style="color: #506018 !important; font-size:15px !important;">VEN-ACC-001</span>
      </label>
    </div>
  </div>

  <!-- Right Column: Amount Summary -->
  <div class="col-md-6 d-flex flex-column align-items-end">
    <div class="w-100" style="max-width: 300px;">
      <div class="d-flex justify-content-between">
        <div>Total Amount:</div>
        <div id="ttl_span_amnt_2" class="fw-bold text-success" style="color:#506018!important; font-size:17px;"></div>
      </div>
      <div class="d-flex justify-content-between">
        <div>Additional Charges:</div>
        <div id="add_amount" class="fw-bold text-success" style="color:#506018!important; font-size:17px;"></div>
      </div>
      <div class="d-flex justify-content-between">
        <div>TDS Deduction:</div>
        <div id="tds_value_detuctioncom" class="fw-bold text-success" style="color:#506018!important; font-size:15px;"></div>
      </div>
      <div class="d-flex justify-content-between">
        <div>Other Deduction:</div>
        <div id="othersvalcom" class="fw-bold text-success" style="color:#506018!important; font-size:15px;"></div>
      </div>
        <div class="d-flex justify-content-between">
          <span>Advance Amount:</span>
          <span id="advanceamount2" class="fw-bold" style="font-size: 16px;color:#506018"></span>
        </div>
      <div class="d-flex justify-content-between">
        <div>Total Payable Amount:</div>
        <div id="tot_payamountcom" class="fw-bold text-success" style="color:#506018!important; font-size:15px;"></div>
      </div>
    </div>
  </div>
</div>

              <!-- Approved Date and Total Amount (same row) -->
              <!-- <div class="col-md-12 d-flex justify-content-between align-items-center"> -->
                <!-- Approved Date -->
             

            
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
            
            </div>

               <div class="table-responsive mt-3">
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


<script>
// function get_prev_stage(){

//   var status = $('#ven_approval_sts').val();

//   if(status == '2'){



//   }
// }



 function removeRedBorder(textarea) {
    textarea.style.border = '1px solid #ced4da'; // reset border
    document.getElementById('remarkError').style.display = 'none';
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

document.getElementById('ven_approval_sts').addEventListener('change', function () {

    const rejectLabel = document.getElementById('rejectlabel');
    const prevStage   = document.getElementById('prev_stage_div');

    if (this.value === '2') { // Reject
        rejectLabel.classList.remove('d-none');
        prevStage.classList.remove('d-none');
    } else {
        rejectLabel.classList.add('d-none');
        prevStage.classList.add('d-none');

        // reset values
        document.getElementById('reject_reason').value = '';
        document.getElementById('prev_stage').value = '';
    }
});





function vendor_payment() {
    $('#apprvl_btn').show();

    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var bill_no = $('#bill_no').text();
    var accountbillid = $('#accountbillid').text();
    var url = sessionStorage.getItem("list_link");

    var reject_reason = $('#reject_reason').val().trim();
    var acc_approval_sts = $('#ven_approval_sts').val();

    var prev_stage = $('#prev_stage').val();

    // 🔴 Validation: If Rejected, reject_reason is required
    if (acc_approval_sts === '2' && reject_reason === '' ) {
        Swal.fire({
            icon: 'warning',
            title: 'Reject Reason Required',
            text: 'Please enter the reject reason before submitting.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then(() => {
            $('#prev_stage').focus();
              $('#prev_stage').css('border', '1px solid red'); // show red border
            document.getElementById('remarkError').style.display = 'inline';
        });
        return; // ✅ Completely stop function here (no AJAX)
    }

     if (acc_approval_sts === '2' && prev_stage == '' ) {
        Swal.fire({
            icon: 'warning',
            title: 'Select Previous Stage ',
            text: 'Please Choose the Previous Stage before submitting.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then(() => {
            $('#reject_reason').focus();
              $('#reject_reason').css('border', '1px solid red'); // show red border
            document.getElementById('remarkError').style.display = 'inline';
        });
        return; // ✅ Completely stop function here (no AJAX)
    }

    // ✅ Proceed only if validation passes
    var hasError = false;

    $('#vendor_datatable tbody tr').each(function () {
        var row = $(this);

        var selected_status = row.find('.status-select').val();
        var dc_no = row.find('td').eq(1).text().trim();
         var dc_num = $('#hidden_dc').val();
        var unique_id = row.find('.status-select').attr('data-unique-id');

        if (!unique_id) {
            console.warn('Missing unique_id for DC:', dc_no);
            hasError = true;
            return; // skip this row
        }

        let data = {
            dc_no: dc_no,
            crct_dc_num : dc_num,
            bill_no: bill_no,
            accountbillid: accountbillid,
            unique_id: unique_id,
            acc_approval_sts: acc_approval_sts,
            reject_reason: reject_reason,
            prev_stage:prev_stage,
            action: "finance_approval"
        };

        console.log('Sending Data:', data);

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            async: false, // ensures requests complete in order
            success: function (response) {
                console.log(`Status Updated for DC ${dc_no} | Status: ${selected_status}`);
            },
            error: function () {
                hasError = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `Network error for DC ${dc_no}`
                });
            }
        });
    });

    // ✅ Redirect or success alert only if no error
    if (!hasError) {

        setTimeout(function () {
           sweetalert('create', url);
        }, 1000);
    }
}




  $(document).on('click', '.view-btn', function () {
    var bill_no = $(this).data('bill-no');
    var vendor = $(this).data('vendor');

    var remark  = $(this).data('remark');

    // alert(vendor);
    var bill_date = $(this).data('bill-date');

    var mail = $(this).data('vendor-mail');
    var contact = $(this).data('vendor-mobile');
    var address = $(this).data('vendor-address');

    var ttl_amount = $(this).data('ttl-amount');
    var additional_amount = $(this).data('additional-amount');

    var vendor_name = $(this).data('vendor-name');



    
    var accountbillid = $(this).data('accountbillid');

    var acctotalpaybleamount = $(this).data('acctotalpaybleamount');
    
    var acctdsvalue = $(this).data('acctdsvalue');

    var accotherdeduction = $(this).data('accotherdeduction');

    var advancepayment = $(this).data('advancepayment');

    $('#advanceamount1').text(advancepayment);
    $('#add_charges').text(additional_amount);
    

// console.log(accountbillid);
    $('#accountbillid').text(accountbillid);


    
    $('#tds_value_detuction').text(acctdsvalue);
    $('#othersval').text(accotherdeduction);
   $('#tot_payamount').text(acctotalpaybleamount);



    // Populate modal header
    $('#bill_no').text(bill_no);
    $('#bill_date').text(bill_date);

    $('#mail').text(mail);
    $('#contact').text(contact);
    $('#address').text(address);


    $('#vndr_name').text(vendor_name);

 if (remark) {
        $('#remark').val(remark); // Show the remark in the textarea
    } else {
        $('#remark').val(''); // If no remark, ensure the textarea is empty
    }
    // $('#ttl_span_amnt').text(ttl_amount);

    // $('#ttl_span_amnt').text(Math.round(ttl_amount).toLocaleString('en-IN'));

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


if(res.summary_data.pan_attach_file_name) {
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
          const firstRow = res.data[0];

            // $('#accountbillid1').show().text(firstRow.accountbillid || '-');
        // $('#tot_payamount1').show().text(firstRow.acctotalpaybleamount || '-');
        $('#tot_payamount1').show().text(
    firstRow.acctotalpaybleamount 
        ? '₹ ' + parseFloat(firstRow.acctotalpaybleamount).toLocaleString('en-IN', { 
            minimumFractionDigits: 2, 
            maximumFractionDigits: 2 
          }) 
        : '-'
);

//  $('#tds_value_detuction1').show().text(firstRow.acctdsvalue || '-');
//         $('#othersval1').show().text(firstRow.accotherdeduction || '-');
// TDS Deduction
$('#tds_value_detuction1').show().text(
    firstRow.acctdsvalue 
        ? '₹ ' + parseFloat(firstRow.acctdsvalue).toLocaleString('en-IN', { 
            minimumFractionDigits: 2, 
            maximumFractionDigits: 2 
          }) 
        : '-'
);
$('#add_charge2').show().text(
    firstRow.additional_amount 
        ? '₹ ' + parseFloat(firstRow.additional_amount).toLocaleString('en-IN', { 
            minimumFractionDigits: 2, 
            maximumFractionDigits: 2 
          }) 
        : '-'
);
// Others Deduction
$('#othersval1').show().text(
    firstRow.accotherdeduction 
        ? '₹ ' + parseFloat(firstRow.accotherdeduction).toLocaleString('en-IN', { 
            minimumFractionDigits: 2, 
            maximumFractionDigits: 2 
          }) 
        : '-'
);



$('#vendor_bill_created').text(firstRow.vendor_bill_created);
$('#vendor_bill_approved').text(firstRow.vendor_bill_approved);
$('#accdetuctionremarks').text(firstRow.accdetuctionremarks);

$('#acc_bill').text(firstRow.acc_bill);

$('#hidden_dc').val(firstRow.dc_no);




        
  $('#ven_inv_id_1').text(firstRow.veninvverifyid || '-');
        $('#ven_inv_date_1').text(firstRow.vendor_inv_attach_approval_date || '-');

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
    var fileUrl = "http://122.165.127.123:35267/otm_beta/uploads/vendorpayment/PO copy/" + firstRow.po_ven_filename;
    $('#ven_po_attach_1').html(
        '<a href="javascript:void(0);" onclick="window.open(\'' + fileUrl + '\', \'_blank\', \'width=800,height=600\')">' +
            '<img src="uploads/vendorpayment/pdf.png" height="20px" width="20px" alt="Preview PDF">' +
        '</a>'
    );
} else {
    $('#ven_po_attach_1').text('N/A');
}


          let tableHtml = '';
         let sum_rate = 0;
let sum_basic = 0;
let sum_gst_amt = 0;
let sum_total = 0;

          res.data.forEach((row, index) => {
            let rate = getNumberFromHtml(row.rate);
    let basic = getNumberFromHtml(row.basicamt);
    let gst_amt = getNumberFromHtml(row.gstcamt);
    let total = getNumberFromHtml(row.amount);

    sum_rate += rate;
    sum_basic += basic;
    sum_gst_amt += gst_amt;
    sum_total += total;

            tableHtml += `
            <tr>
              <td>${index + 1}</td>
              <td>${row.dc_number}</td>
              <td>${row.invoice_no}</td>
              <td>${row.po_num}</td>
              <td>${row.invoice_qty}</td>
              <td>${capitalizeWords(row.consignee_name)}</td>
              <td>${row.rate}</td>
      <td style="text-align:right;">${row.basicamt || 0}</td>

              <td>${row.gst}</td>
      <td style="text-align:right;">${row.gstcamt || 0}</td>

              <td> ${row.amount}</td>
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
          // <td>${row.dc_date}</td>// ✅ append table
$('#vendor_datatable tbody').html(tableHtml);

// ✅ update footer
$('#sum_rate').text(sum_rate.toLocaleString('en-IN', {minimumFractionDigits:2}));
$('#sum_basic').text(sum_basic.toLocaleString('en-IN', {minimumFractionDigits:2}));
$('#sum_gst_amt').text(sum_gst_amt.toLocaleString('en-IN', {minimumFractionDigits:2}));
$('#sum_total').text(sum_total.toLocaleString('en-IN', {minimumFractionDigits:2}));

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


    // var accountbilldatecom = $(this).data('accountbilldatecom');
    var accountbillidcom = $(this).data('accountbillidcom');
    var tot_payamountcom = $(this).data('payamountcom');
    var tds_value_detuctioncom = $(this).data('tds_value_detuctioncom');
    var othersvalcom = $(this).data('othersvalcom');

    var advanceamount = $(this).data('advancepayment');
$('#advanceamount2').text(advanceamount);



    
    $('#bill_no_2').text(bill_no);
    $('#bill_date_2').text(bill_date);
    $('#approver_1').text(approver);
    $('#approvedate_1').text(approvedate);
    $('#approver_2').text(approver);
    $('#approvedate_2').text(approvedate);

    $('#financerejectreason_2').text(financerejectreason);

        $('#accountbillidcom').text(accountbillidcom || '-');
        $('#tot_payamountcom').text(tot_payamountcom || '-');
        $('#tds_value_detuctioncom').text(tds_value_detuctioncom || '-');
        $('#othersvalcom').text(othersvalcom || '-');

    $('#viewModal-2').modal('show');


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

         
// PAN File
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

          const firstRow = res.data[0];


//  $('#approvedate_1').show().text(firstRow.vendor_account_approval_date || '-');
        $('#accountbillid1').show().text(firstRow.accountbillid || '-');
//         $('#tot_payamount1').show().text(firstRow.acctotalpaybleamount || '-');
//  $('#tds_value_detuction1').show().text(firstRow.acctdsvalue || '-');
//         $('#othersval1').show().text(firstRow.accotherdeduction || '-');

       
    $('#tot_payamountcom').text(
    '₹ ' + parseFloat(firstRow.acctotalpaybleamount).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    })
);


$('#add_amount').text(
    '₹ ' + parseFloat(firstRow.additional_amount).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    })
);
    $('#tds_value_detuctioncom').text(
    '₹ ' + parseFloat(firstRow.acctdsvalue).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    })
);

    $('#othersvalcom').text(
    '₹ ' + parseFloat(firstRow.accotherdeduction).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    })
);



  $('#ven_inv_id_2').text(firstRow.veninvverifyid || '-');
        $('#ven_inv_date_2').text(firstRow.vendor_inv_attach_approval_date || '-');


    $('#bill_date_2').text(firstRow.bill_date);

        // $('#remark_1').text(firstRow.bill_remark || '-');

        console.log(firstRow.vendor_inv_attach_approval_date);
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

    // $('#billentryname').text(firstRow.vendor_account_approved_by || '-');
    //          $('#billentrydate').text(firstRow.vendor_account_approval_date || '-');




          let tableHtml = '';
          let ttl_amount = 0;
         let sum_rate = 0;
let sum_basic = 0;
let sum_gst_amt = 0;
let sum_total = 0;
          res.data.forEach((row, index) => {

let rate = getNumberFromHtml(row.rate);
    let basic = getNumberFromHtml(row.basicamt);
    let gst_amt = getNumberFromHtml(row.gstcamt);
    let total = getNumberFromHtml(row.amount);

    sum_rate += rate;
    sum_basic += basic;
    sum_gst_amt += gst_amt;
    sum_total += total;
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
      <td style="text-align:right;">${row.basicamt || 0}</td>

        <td>${row.gst}</td>
      <td style="text-align:right;">${row.gstcamt || 0}</td>

        <td>${row.amount}</td>
      </tr>
    `;
          });

         $('#vendor_datatable_popup tbody').html(tableHtml);

$('#popup_sum_rate').text(sum_rate.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
$('#popup_sum_basic').text(sum_basic.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
$('#popup_sum_gst_amt').text(sum_gst_amt.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
$('#popup_sum_total').text(sum_total.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
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
// document.getElementById('ven_approval_sts').addEventListener('change', function () {
//     const reasonInput = document.getElementById('reject_reason');
//     const rejectLabel = document.getElementById('rejectlabel'); // make sure label has this ID

//     if (this.value === '2') {
//         reasonInput.style.display = 'block';
//         rejectLabel.style.display = 'block';
//     } else {
//         reasonInput.style.display = 'none';
//         rejectLabel.style.display = 'none';
//         reasonInput.value = '';
//     }
// });



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



  function update_remark(){

            var remark = $('#remark').val();

            var bill_no = $('#bill_no').text();

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
                    sweetalert(res.msg,url);
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


function reject_payment(button) {
  const row = $(button).closest('tr');
  const selected_status = row.find('.status-select').val();
  const dc_no_with_date = row.find('td').eq(1).text().trim();
  const unique_id = row.find('.status-select').attr('data-unique-id');
  const reject_reason = row.find('.reject-reason').val() || '';

  if (!reject_reason) {
    Swal.fire({
      icon: 'warning',
      title: 'Missing Reason',
      text: 'Please enter a rejection reason.',
    });
    return;
  }

  const parts = dc_no_with_date.split(/\s+/);
  const dc_no = parts[0];
  const ajax_url = sessionStorage.getItem("folder_crud_link");
  const bill_no = $('#bill_no').text();




  Swal.fire({
    title: 'Are you sure?',
    text: "Do you really want to reject this payment?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, reject it!',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      // Visually update row
      row.find('.status-select').replaceWith('<span class="text-danger fw-bold">Rejected</span>');
      row.find('.reject-section').hide();

      // Perform AJAX call
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
          console.log("Rejected successfully");

          let res = typeof response === 'string' ? JSON.parse(response) : response;

          if (res.total_amount) {
            let roundedAmount = Math.round(res.total_amount);
            let formattedAmount = roundedAmount.toLocaleString('en-IN');
            $('#ttl_span_amnt').text(formattedAmount);
            //  $('#tot_payamount1').text(formattedAmount);
          }

          Swal.fire({
            icon: 'success',
            title: 'Rejected!',
            text: 'The Account Bill has been rejected successfully.',
            timer: 2000,
            showConfirmButton: false
          });
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong while rejecting the payment.'
          });
        }
      });
    }
  });
}


//   function vendor_payment() {
//     $('#apprvl_btn').show();

//     var ajax_url = sessionStorage.getItem("folder_crud_link");
//     var bill_no = $('#bill_no').text();
//     var accountbillid = $('#accountbillid').text();


//     var url = sessionStorage.getItem("list_link");

//     $('#vendor_datatable tbody tr').each(function () {
//       var row = $(this);

//       var selected_status = row.find('.status-select').val();
//       // alert(selected_status);
//       var dc_no = row.find('td').eq(1).text().trim();
//       // var unique_id = row.find('.status-select').data('unique-id');

//       var unique_id = row.find('.status-select').attr('data-unique-id');

//       // alert(unique_id);

//       if (!unique_id) {
//         console.warn('Missing unique_id for DC:', dc_no);
//         return; // skip this row
//       }

      
//        var reject_reason = $('#reject_reason').val();
//     var acc_approval_sts = $('#ven_approval_sts').val();

//  // 🔴 Validation: If Rejected, reject_reason is required
//     if (ven_approval_sts === '2' && reject_reason === '') {
//         Swal.fire({
//             icon: 'warning',
//             title: 'Reject Reason Required',
//             text: 'Please enter the reject reason before submitting.',
//             confirmButtonColor: '#3085d6',
//             confirmButtonText: 'OK'
//         }).then(() => {
//             $('#reject_reason').focus();
//         });
//         return false; // ✅ Completely stop the function
//     }
//     var hasError = false; // flag to check if any error occurs before sending

//       let data = {
//         dc_no: dc_no,
//         bill_no: bill_no,
//         accountbillid:accountbillid,
//         unique_id: unique_id,
//         acc_approval_sts: acc_approval_sts,
//         reject_reason: reject_reason,
//         action: "finance_approval"
//       };

//       console.log('Sending Data:', data);

//       $.ajax({
//         type: "POST",
//         url: ajax_url,
//         data: data,
//         success: function (response) {
//           console.log(`Status Updated for DC ${dc_no} | Status: ${selected_status}`);
//         },
//         error: function () {
//           alert(`Network error for DC ${dc_no}`);
//         }
//       });
//     });

//     // Delay redirect or alert slightly to wait for all AJAX calls
//     setTimeout(function () {
//       sweetalert('create', url);
//     }, 1000);
//   }



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

  function getNumberFromHtml(value) {
    if (value === null || value === undefined) return 0;

    let text = $('<div>').html(value).text().trim();   // remove HTML
    text = text.replace(/,/g, '').replace('%', '').replace(/[^\d.-]/g, ''); // keep only number chars

    return parseFloat(text) || 0;
}
</script>
