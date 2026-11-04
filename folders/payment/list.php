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

    .scrollable-modal-body {
        max-height: 75vh;
        overflow-y: auto;
    }
</style>
<?php
//   $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val = '6827245a6f90947753';
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];
?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Payment</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
                value="<?php echo $screen_id_val; ?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
                value="<?php echo $user_type_unique_id; ?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Form</a></li>
                    <li class="breadcrumb-item active">Payment</li>
                </ol>
            </div>
        </div>
        <div>
            <!-- <button type="button" id="export" name="export"
                class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
                <i class="ri-file-excel-2-fill"></i>
            </button> -->
        </div>
    </div>
</div>
<!----content start---------->
<div class="col-xxl-12">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills arrow-navtabs  bg-light mb-3" role="tablist">
                <li class="nav-item">
                    <!--onclick="dispatch_pending()"-->
                    <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                        <span class="d-none d-sm-block">Pending</span>
                    </a>
                </li>

                <li class="nav-item">

                    <a class="nav-link " data-bs-toggle="tab" href="#arrow-remaining" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Completed</span>
                    </a>
                </li>


                <!-- <li class="nav-item">
                  
                    <a class="nav-link active" data-bs-toggle="tab" href="#arrow-completed" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                        <span class="d-none d-sm-block">Completed</span>
                    </a>
                </li> -->
                <!-- <li class="nav-item" > -->
                <!--onclick="dispatch_pending()"-->
                <!-- <a class="nav-link " data-bs-toggle="tab" href="#arrow-pending" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Pending 25%</span>
                    </a>
                </li>
                <li class="nav-item" > -->
                <!--onclick="dispatch_pending()"-->
                <!-- <a class="nav-link " data-bs-toggle="tab" href="#arrow-remaining" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Pending 5%</span>
                    </a>
                </li> -->
                <!-- <li class="nav-item" > -->
                <!--onclick="dispatch_transist()"-->
                <!-- <a class="nav-link" data-bs-toggle="tab" href="#arrow-profile" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Partially Completed</span>
                    </a>
                </li> -->
                <!-- <li class="nav-item" > -->
                <!--onclick="dispatch_delivery()"-->
                <!-- <a class="nav-link" data-bs-toggle="tab" href="#arrow-contact" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                        <span class="d-none d-sm-block">Completed</span>
                    </a> -->
                <!-- </li> -->
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                    <div class="row align-items-end">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label from-date-label">From Date</label>
                                                <input type="date" class="form-control" id="from_date" name="from_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label from-date-label">To Date</label>
                                                <input type="date" class="form-control" id="to_date" name="to_date">
                                            </div>
                                        </div>



                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label from-date-label">Select date type</label>
                                                <select class="form-select mb-3" id="opt" name="opt">
                                                    <option value="">Select date type</option>
                                                    <option value="4">PO Date</option>
                                                    <option value="5">Invoice Date</option>
                                                    <!-- <option value="6">Payment Date</option> -->
                                                    <option value="7">Bill Submission Date</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="mb-3">

                                                <button type="button" class="btn btn-primary btn-lg gos"
                                                    onclick="get_data()">Go</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="list">
                                        <div class="table-responsive">
                                            <table id="payment_datatable"
                                                class="table table-bordered table-striped align-middle table-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Bill NO</th>
                                                        <th>PO NO</th>
                                                        <th>Customer Name</th>
                                                        <th>Invoice NO</th>
                                                        <th class="text-end">Invoice Value</th>
                                                        <th>Claim (%)</th>
                                                        <th>Claim Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!--<tr>-->
                                                    <!--    <td>01</td>-->
                                                    <!--    <td>001</td>-->
                                                    <!--    <td>2023-10-02</td>-->
                                                    <!--    <td>Ocean Clothes</td>-->
                                                    <!--    <td>Chennai</td>-->
                                                    <!--    <td>1000</td>-->
                                                    <!--    <td>2023-10-02</td>-->
                                                    <!--    <td>-->
                                                    <!--        <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">-->
                                                    <!--            <i-->
                                                    <!--                class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i>-->
                                                    <!--        </a>-->
                                                    <!--    </td>-->
                                                    <!--</tr>-->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----content start---------->

                </div>
                <!-- pending 25% -->
                <div class="tab-pane" id="arrow-completed" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="ss" class="table table-bordered table-striped align-middle">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Bill Date</th>

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

                </div>
                <!-- end -->
                <!-- pending 5 -->
                <div class="tab-pane" id="arrow-remaining" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">


                                 <div class="row align-items-end">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label from-date-label">From Date</label>
                                                <input type="date" class="form-control" id="from_c_date" name="from_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label from-date-label">To Date</label>
                                                <input type="date" class="form-control" id="to_c_date" name="to_date">
                                            </div>
                                        </div>



                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label from-date-label">Select date type</label>
                                                <select class="form-select mb-3" id="optc" name="optc">
                                                    <option value="">Select date type</option>
                                                    <option value="4">PO Date</option>
                                                    <option value="5">Invoice Date</option>
                                                    <option value="6">Payment Date</option>
                                                    <option value="7">Bill Submission Date</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="mb-3">

                                                <button type="button" class="btn btn-primary btn-lg gos"
                                                    onclick="get_completeddata()">Go</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="payment_completed_datatable"
                                            class="table table-bordered table-striped align-middle">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Bill NO</th>
                                                    <th>PO NO</th>
                                                    <th>Customer Name</th>
                                                    <th>Invoice NO</th>
                                                    <th class="text-end">Invoice Value</th>
                                                    <th>Claim (%)</th>
                                                    <th>Claim Amount</th>
                                                    <th>Action</th>
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

                </div>
                <!-- end -->
                <!-- fixed-header  -->

                <!----content start---------->

            </div>
        </div><!-- end card-body -->
    </div><!-- end card -->
</div>
<!--end col-->
</div>
<!--end row-->
<!-- Page content Ends Here -->
</div>
</div>
</div>


<div class="modal fade" id="billDetailsModal" tabindex="-1" aria-labelledby="billDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header p-3" style="background-color:#506018;">
                <h5 class="modal-title" style="color:white ;" id="billDetailsModalLabel">Bill Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>

            <div class="modal-body scrollable-modal-body" id="bill-details-content">
                <div class="row">
                    <div class="col-md-3">

                        <!-- Left Section -->
                        <!-- Left Section -->

                        <div class="card">
                            <div class="card-body" style="background-color: #eeece0 !important;">
                                <h6 class="text-uppercase fw-semibold mb-3"
                                    style="display: inline-block; border-bottom: 1px solid grey; padding-bottom: 5px;">
                                    Customer Details
                                </h6>

                                <h6><span id="customer" class="fw-bold"></span></h6>
                                <h6><span id="address" class="fw-bold"></span></h6>

                                <h6><span id="dist_name" class="fw-bold"></span></h6>
                                <h6><span id="stat_name" class="fw-bold"></span></h6>

                                <h6><span id="pincode" class="fw-bold"></span></h6>
                            </div>

                        </div>
                        <div class="card">
                            <div class="card-body" style="background-color: #eeece0 !important;">
                                <h6 class="text-uppercase fw-semibold mb-3 mt-2"
                                    style="display: inline-block; border-bottom: 1px solid grey; padding-bottom: 5px;">
                                    Contact Details
                                </h6>
                                <h6><span id="contact_name" class="fw-bold"><?= $contact_name; ?></span></h6>
                                <h6><span id="contact_no" class="fw-bold"><?= $contact_number; ?></span></h6>
                                <h6><span id="email" class="fw-bold"><?= $email; ?></span></h6>
                            </div>
                        </div>


                    </div>

                    <!-- Center Section -->
                    <!-- <div class="col-4 text-start">
                <h6 class="text-uppercase fw-semibold mb-3"
                  style="display: inline-block; border-bottom: 1px solid grey; padding-bottom: 5px;">Bill Details</h6>
                <h6><span>Bill No </span>: <span class="fw-bold"><?php echo $bill_no; ?></span></h6>
                <h6><span>Bill Date </span>: <span class="fw-bold"><?php echo $bill_created_date; ?></span></h6>
                <h6><span>ENo </span>: <span class="fw-bold"><?php echo $e_no; ?></span></h6>
                <h6><span>Bill Submission Date </span>: <span class="fw-bold"><?php echo $bill_submission_date; ?></span>
                </h6>
              </div> -->

                    <!-- BILL DETAILS Section -->


                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-6">
                                <h6 class=" fw-semibold mb-3"
                                    style="border-bottom: 1px solid grey;  padding-bottom: 5px;">BILL DETAILS</h6>

                                <div class="row mb-2">
                                    <div class="col-5 text-start">Bill No</div>
                                    <div class="col-1 text-center">:</div>
                                    <div class="col-6 fw-bold" id="bill_num"><?php echo $bill_no; ?></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-5 text-start">Bill Date</div>
                                    <div class="col-1 text-center">:</div>
                                    <div class="col-6 fw-bold" id="bill_c_date"><?php echo $bill_created_date; ?></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-5 text-start">ENo</div>
                                    <div class="col-1 text-center">:</div>
                                    <div class="col-6 fw-bold" id="e_no"><?php echo $e_no; ?></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-5 text-start">Bill Submission Date</div>
                                    <div class="col-1 text-center">:</div>
                                    <div class="col-6 fw-bold" id="bill_sub_date"><?php echo $bill_submission_date; ?>
                                    </div>
                                </div>
                            </div>





                            <!-- Right Section -->

                            <div class="col-6">
                                <h6 class=" fw-semibold mb-3 text-uppercase"
                                    style="border-bottom: 1px solid grey; padding-bottom: 5px;">Invoice Details</h6>

                                <!-- PO Date -->
                                <div class="row mb-2">
                                    <div class="col-5 text-start">PO Date</div>
                                    <div class="col-1 text-center">:</div>
                                    <div class="col-6 fw-bold" id="po_date"></div>
                                </div>

                                <!-- PO No -->
                                <div class="row mb-2">
                                    <div class="col-5 text-start">PO No</div>
                                    <div class="col-1 text-center">:</div>
                                    <div class="col-6 fw-bold" id="po_num"></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-5 text-start">Invoice Date</div>
                                    <div class="col-1 text-center">:</div>
                                    <div class="col-6 fw-bold" id="invoice_date"></div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-5 text-start">Invoice NO</div>
                                    <div class="col-1 text-center">:</div>
                                    <div class="col-6 fw-bold" id="invoice_no"></div>
                                </div>


                                <div class="row mb-2">
                                    <div class="col-5 text-start">Invoice Value</div>
                                    <div class="col-1 text-center">:</div>
                                    <div class="col-6 fw-bold" id="invoice_vlue"></div>
                                </div>





                                <!-- <div class="row mb-2" style="margin-top: 10px;">
      <h6 class="text-center fw-semibold mb-3 mt-3 text-uppercase" style="border-bottom: 1px solid grey;">BG Details</h6>

    <div class="col-5 text-start">BG(%)</div>
    <div class="col-1 text-center">:</div>
    <div class="col-6 fw-bold" id="bg_percent"><?php echo $bg_percent; ?></div>
  </div>

  <div class="row mb-2">
    <div class="col-5 text-start">BG Value</div>
    <div class="col-1 text-center">:</div>
    <div class="col-6 fw-bold" id="bg_"><?php echo $bg_value; ?></div>
  </div> -->
                            </div>

                            <div class="col-12"> <!-- Transaction Details Row -->
                                <div class="row mt-4">
                                    <h6 class="text-uppercase fw-semibold mb-3"
                                        style="border-bottom: 1px solid grey; padding-bottom: 5px;">
                                        Transaction Details
                                    </h6>

                                    <!-- Left 5 Fields -->
                                    <div class="col-6">



                                        <div class="row mb-2">
                                            <div class="col-5 text-start">Transaction Date</div>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-6 fw-bold" id="transc_date">Cash</div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-5 text-start">Reference</div>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-6 fw-bold" id="transc_ref"></div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-5 text-start">Transaction Amount</div>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-6 fw-bold" id="transc_amnt"></div>
                                        </div>





                                        <div class="row mb-2">
                                            <div class="col-5 text-start">Payment Date</div>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-6 fw-bold" id="paid_date">20-06-2025</div>
                                        </div>



                                        <div class="row mb-2">
                                            <div class="col-5 text-start">Status</div>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-6 fw-bold text-success">Completed</div>
                                        </div>

                                    </div>



                                    <div class="col-6">


                                        <div class="row mb-2">
                                            <div class="col-5 text-start">Received Amount</div>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-6 fw-bold" id="transc_rec"></div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-5 text-start">LD Detected Amount</div>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-6 fw-bold" id="transc_ld"></div>
                                        </div>



                                        <div class="row mb-2">
                                            <div class="col-5 text-start">GST Amount</div>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-6 fw-bold" id="transc_gst"></div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-5 text-start">TDS Amount</div>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-6 fw-bold" id="transc_tds"></div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-5 text-start">Total Amount</div>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-6 fw-bold" id="ttl_amnt"></div>
                                        </div>


                                        <div class="row mb-2">
                                            <div class="col-5 text-start">Claim Amount</div>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-6 fw-bold" id="claim_amnt"></div>
                                        </div>


                                        <div class="row mb-2">
                                            <div class="col-5 text-start">Balance Amount</div>
                                            <div class="col-1 text-center">:</div>
                                            <div class="col-6 fw-bold" style="font-size:large;" id="bbl_amnt"></div>
                                        </div>
                                    </div>


                                    <!-- Right 5 Fields -->

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










<script>

    $(document).on('click', '.view-btn', function () {

        var po_unique_id = $(this).data('po-unique-id');

        var invoice_no = $(this).data('invoice-no');

        var bill_no = $(this).data('bill-no');

        // Load content via AJAX
        //   $('#bill-details-content').html('Loading...');

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        var data = {

            "po_unique_id": po_unique_id,
            "invoice_no": invoice_no,
            "bill_no": bill_no,
            "action": "get_completed_bill"

        }


        $.ajax({
            url: ajax_url, // your backend endpoint
            type: 'POST',
            data: data,
            success: function (response) {


                if (typeof response === "string") {
                    response = JSON.parse(response);
                }


                if (response.data && Array.isArray(response.data) && response.data.length > 0) {
                    var resData = response.data[0];

                    // Now safely use resData values
                    var bill_no = resData.bill_no;
                    var invoice_no = resData.invoice_no;


                    document.getElementById('customer').textContent = resData.customer;
                    document.getElementById('address').textContent = resData.address;

                    document.getElementById('pincode').textContent = resData.pincode;


                    document.getElementById('contact_name').textContent = resData.contact_name.toUpperCase();


                    document.getElementById('contact_no').textContent = resData.contact_number;

                    document.getElementById('email').textContent = resData.email;

                    document.getElementById('bill_c_date').textContent = resData.bill_created_date;


                    document.getElementById('bill_sub_date').textContent = resData.bill_submission_date;
                    document.getElementById('bill_num').textContent = resData.bill_no;
                    document.getElementById('email').textContent = resData.email;



                    document.getElementById('po_num').textContent = resData.po_num;
                    document.getElementById('po_date').textContent = resData.po_date;
                    document.getElementById('invoice_no').textContent = resData.invoice_no;
                    document.getElementById('invoice_date').textContent = resData.invoice_date;

                    document.getElementById('transc_date').textContent = resData.trans_date;

                    document.getElementById('transc_ref').textContent = resData.trans_id;
                    document.getElementById('transc_amnt').textContent = resData.tran_amt;
                    document.getElementById('transc_rec').textContent = resData.payment_received;
                    document.getElementById('transc_ld').textContent = resData.ld_amount;
                    document.getElementById('transc_gst').textContent = resData.gst_value;
                    document.getElementById('transc_tds').textContent = resData.tds_value;
                    document.getElementById('paid_date').textContent = resData.payment_date;

                    document.getElementById('invoice_vlue').textContent = resData.invoice_value;
                    document.getElementById('claim_amnt').textContent = resData.claimamt;

                    document.getElementById('e_no').textContent = resData.e_no;

                    document.getElementById('dist_name').textContent = resData.district;

                    document.getElementById('stat_name').textContent = resData.state_name;

                    document.getElementById('ttl_amnt').textContent = resData.ttl_amount;

                    document.getElementById('bbl_amnt').textContent = resData.balance_amount;




                    // payment_received   balance_amount
                    // claimamt invoice_value
                    // etc...
                } else {
                    console.error("No data found in response");
                }
                // alert('2');
                // Load response into modal body

                // Open modal using Bootstrap 5's native JS
                const billModal = new bootstrap.Modal(document.getElementById('billDetailsModal'));
                billModal.show();




                // Fix backdrop bug (in case modal not closing properly)
                $('#billDetailsModal').on('hidden.bs.modal', function () {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                });
                //   $('#bill-details-content').html(response);
            },
            error: function () {
                $('#bill-details-content').html('<div class="text-danger">Failed to load data.</div>');
            }
        });
    });


















    $("#export").click(function () {
        // alert("hi");
        window.location = "folders/payment/excel.php";
        // window.location = "https://122.165.127.123:35267/otm_beta/folders/payment/excel.php";
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

                var addButton = document.getElementById('add_btn');

                if (dataString.includes('5f8807ff00bf726601')) {
                    if (addButton) {
                        addButton.style.visibility = 'visible';  // Show the button
                    }
                } else {
                    if (addButton) {
                        addButton.style.visibility = 'hidden';  // Show the button
                    }
                }
                var listpage = document.getElementById('list');
                if (dataString.includes('5f88083fd50a344823')) {
                    if (listpage) {
                        listpage.style.visibility = 'visible';  // Show the button
                    }
                } else {
                    if (listpage) {
                        listpage.style.visibility = 'visible';  // Show the button
                    }
                }


            },
            error: function (data) {
                alert("Network Error");
            }
        });
    }

</script>
