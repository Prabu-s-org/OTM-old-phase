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

    span.invoice_date {
        white-space: nowrap;
    }

    .action-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin-right: 5px;
        font-size: 18px;
        text-align: center;
        vertical-align: middle;
    }

    table.dataTable thead tr th {
        text-align: center;
    }
   
/* table.dataTable th.dt-type-numeric,
table.dataTable td.dt-type-numeric {
  text-align: right !important;
} */
.btn-greens a button {
    background: #506018;
    border: 0px;
    /* margin-bottom: 10px !important; */
}
</style>


<?php
$screen_id_val = '641ad5b47d02a30030';
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];
?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Purchase Order</h4>


            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control" value="<?php echo $screen_id_val; ?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control" value="<?php echo $user_type_unique_id; ?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                    <li class="breadcrumb-item active"> PO Order</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row mt-2 po-class">
    <div class="col-md-4">

        <!-- <div class="input-group"> -->
            <!-- value="<?php echo date('Y-m'); ?>" -->
            <!-- <input type="month" id="month_fill" name="month_fill" class="form-control">
          
            <button type="button" id="date_filter" name="date_filter" class="input-group-text thme-colo btn btn-primary border-primary text-white"
                onclick="get_data_month()">GO</button>
        </div> -->
    </div>

    <div class="col-md-5"></div>

   

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
                        <span class="d-none d-sm-block">Po List</span>
                    </a>
                </li>
                <li class="nav-item">
                    <!--onclick="dispatch_transist()"-->
                    <a class="nav-link" data-bs-toggle="tab" href="#arrow-profile" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Po Cancel List </span>
                    </a>
                </li>

            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                 <div class="col-md-3 mb-1 d-grid gap-2 d-md-flex justify-content-md-end btn-greens" style="margin-left: 76%;">
                    <label class="form-label from-date-label"></label>
        <!-- <?php echo btn_add($btn_add); ?> -->
        <div class="">
           
        </div>
    </div>
                <div class="tab-pane active" id="arrow-overview" role="tabpanel">

                   
                    <div class="row" id="list">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                    <div class="row align-items-end" style="
    margin-top: -32px;">
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

                                        <div class="col-md-1">
                                            <div class="mb-3">

                                                <button type="button" class="btn btn-primary btn-lg gos" onclick="get_data()">Go</button>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="mb-3" style="float: right;">
                                            <!-- mb-1 d-grid gap-2 d-md-flex justify-content-md-end btn-greens" style="margin-left: 76%;" -->
                                                <?php echo btn_add($btn_add); ?>
                                            <!-- <div class=""> </div> -->
                                            </div>
                                        </div>
                                            <!-- <button type="button" id="export1" name="export1" class="btn btn-primary  waves-effect waves-light wavw  mb-1">
                                                <i class="ri-file-excel-2-fill"></i>
                                            </button> -->
                                        <!-- </div> -->
                                    </div>
                                     

                                    <div class="table-responsive">
                                        <table id="po_form_datatable" class="table table-bordered table-striped align-middle">
                                            <!-- <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>PO Date</th>
                                                    <th>PO No.</th>
                                                    <th>Customer Details</th>
                                                    <th>Executive</th> -->
                                                    <!-- <th>Customer GST Number </th> -->
                                                    <!-- <th>State</th> -->
                                                    <!-- <th>District</th> -->
                                                     <!-- <th>Product Cnt</th>
                                                     <th>Product Qty</th>
                                                     <th>Consignee Cnt</th>
                                                    <th>PO Value</th>
                                                    <th>LD Required</th>
                                                    <th>Attach</th> -->
                                                    <!-- <th>PO Cancel</th> -->
                                                    <!-- <th style="width: 11%;">Action</th>

                                                </tr>
                                            </thead> -->
                                             <thead>
    <!-- First header row: grouping "Product" over two columns -->
    <tr>
      <th rowspan="2">S.No</th>
      <th rowspan="2">PO Date</th>
      <th rowspan="2">PO No.</th>
      <th rowspan="2">Customer Details</th>
      <th rowspan="2">Executive</th>
      <th colspan="2" class="text-center">Product</th>
      <th rowspan="2">Consignee Cnt</th>
      <th rowspan="2" style="min-width: 120px;">Consignee Status</th>
      <th rowspan="2">PO Value</th>
      <th rowspan="2">LD Required</th>
      <th rowspan="2">Attach</th>
      <th rowspan="2" style="width: 11%;">Action</th>
    </tr>
    <!-- Second header row: sub-headers for Product -->
    <tr>
      <th>Count</th>
      <th>Qty</th>
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
                    <!----content start---------->
                    <!--  Extra Large modal example -->
                </div>
                <!-- fixed-header  -->
                <div class="tab-pane" id="arrow-profile" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                   
                                    <div id="list_1">
                                        <div class="table-responsive">
                                            <table id="po_cancel_datatable" class="table table-bordered table-striped align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>PO Number </th>
                                                        <th>PO Date </th>
                                                        <th>State Name</th>
                                                        <th>District Name</th>
                                                        <th>Customer</th>
                                                        <th>Customer GST Number </th>
                                                        <th>Executive Name</th>
                                                        <th>PO Total Value</th>
                                                        <th>PO Cancel Attachment</th>
                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>

                                                    </tr>
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


<!-- Column Visibility Modal -->
<div id="columnVisibilityModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Center the modal and make it large -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Columns to Display</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="columnVisibilityForm">
                    <!-- Dynamically populated checkboxes will go here -->
                    <div class="row">
                        <!-- Each column will have a checkbox -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>

</script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- <script src="/otm_beta/assets/js/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="assets/bundles/jquery-validation/jquery.validate.min.js"></script> -->






<!-- Consignee Verification Status Modal -->
<div class="modal fade" id="consigneeStatusModal" tabindex="-1" aria-labelledby="consigneeStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="consigneeStatusModalLabel">
                    <i class="mdi mdi-map-marker-multiple text-primary"></i> Consignee Verification Details &mdash; PO: <span id="modal_po_num" class="text-primary fw-bold"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 p-2 bg-light rounded border">
                    <div class="mb-2 mb-md-0">
                        <span class="me-3">Total Consignees: <b id="modal_total_cons" class="badge bg-secondary fs-6">0</b></span>
                        <span class="me-3">Verified: <b id="modal_verified_cons" class="badge bg-success fs-6">0</b></span>
                        <span>Pending: <b id="modal_pending_cons" class="badge bg-warning text-dark fs-6">0</b></span>
                    </div>
                    <div>
                        <input type="text" id="modal_consignee_search" class="form-control form-control-sm" placeholder="Search address, contact, district..." style="width: 250px;">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0" id="modal_consignee_table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 45px; text-align:center;">#</th>
                                <th>Branch / Consignee</th>
                                <th>Address</th>
                                <th>District / State</th>
                                <th>Contact Details</th>
                                <th>Assigned Staff</th>
                                <th style="width: 130px; text-align:center;">Status</th>
                                <th style="width: 100px; text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="modal_consignee_tbody">
                            <tr><td colspan="8" class="text-center py-4 text-muted"><i class="fa fa-spinner fa-spin"></i> Loading consignees...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#export").click(function() {
        // alert("hi");
        window.location = "folders/po_form/excel.php";
    });
    $("#export1").click(function() {

        var from_date = $('#from_date').val();
        // alert(from_date);
        var to_date = $('#to_date').val();
        // alert(to_date);
        // var month_fill = $('#month_fill').val();
        window.location = "folders/po_form/excel1.php?from_date=" + from_date + "&to_date=" + to_date;
    });

    function print_pdf_1(file_name) {

        onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }



    $(document).ready(function() {

        new DataTable('#po_form_datatable', {
            layout: {
                topStart: {
                    buttons: ['copy', 'excel', 'pdf', 'colvis']
                }
            }
        });
        get_data();
        sub_list_datatable('po_cancel_datatable', form_name, 'po_cancel_datatable');


    });

    function get_data() {
        // document.getElementById('month_fill').value = '';

        init_datatable(table_id, form_name, action);
    }

    function get_data_month() {

        document.getElementById('from_date').value = '';
        document.getElementById('to_date').value = '';

        init_datatable(table_id, form_name, action);
    }


    function init_datatable(table_id = '', form_name = '', action = '') {
        var table = $("#" + table_id);
        var action = 'datatable';
        var month_fill = $('#month_fill').val();
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val();
        var screen_id_val = $('#screen_id_val').val();
// alert(from_date);
        var user_type_unique_id = $('#user_type_unique_id').val();

        if (month_fill != '') {
            var data = {
                "month_fill": month_fill,
                "from_date":from_date,
                "to_date":to_date,
                "action": action,
                "screen_id_val": screen_id_val,
                "user_type_unique_id": user_type_unique_id,
            };
            var ajax_url = sessionStorage.getItem("folder_crud_link");

            var datatable = table.DataTable({
                destroy: true,
                ordering: true,
                searching: true,
                stateSave:true,
                dom: 'lBfrtip', // Adds the button and column visibility controls to the DOM
                buttons: [{
                        extend: 'copyHtml5',
                        text: 'Copy',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis', // Column visibility button
                        text: 'Column Visibility',
                        action: function(e, dt, node, config) {
                            // Open the column visibility modal when the button is clicked
                            $('#columnVisibilityModal').modal('show');

                            // Populate the modal with checkboxes for each column
                            var columns = dt.columns().header();
                            var form = $('#columnVisibilityForm');
                            form.empty(); // Clear any existing checkboxes

                            // Append checkboxes one by one for each column
                            columns.each(function(header, index) {
                                var isChecked = dt.column(index).visible();
                                var colMarkup = `
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" data-column="${index}" ${isChecked ? 'checked' : ''}>
                                <label class="form-check-label">${$(header).text()}</label>
                            </div>
                        `;
                                form.append(colMarkup); // Append each checkbox in a vertical list
                            });
                        }

                    }
                ],
                ajax: {
                    url: ajax_url,
                    type: "POST",
                    data: data
                },
                columns: [
  { data: "s_no" },
  { data: "po_date" },
  { data: "po_num" },
  {
    data: null,
    render: function(data, type, row) {
      return '<span style="font-weight:bold;">' + row.department + '</span><br>' +
             row.bill_address + '<br>' +
             row.state_name + '<br>' +
             row.district_name + '<br>(' + row.gst_value + ')';
    }
  },
  { data: "executive_name" },
  { data: "pro_cnt" },
  { data: "qty" },
  { data: "cons_cnt", className: "dt-head-center dt-body-center" },
  {
    data: null,
    className: "dt-head-center dt-body-center",
    render: function(data, type, row) {
      let total = parseInt(row.cons_cnt) || 0;
      let verified = parseInt(row.cons_verified_cnt) || 0;
      let pending = parseInt(row.cons_pending_cnt) || 0;
      let po_id = row.raw_unique_id || '';
      if (!po_id && row.unique_id) {
        let m = String(row.unique_id).match(/value="([^"]+)"/);
        if (m) { po_id = m[1]; }
      }
      let po_num = row.raw_po_num || '';
      if (!po_num && row.po_num) {
        po_num = $('<div>').html(row.po_num).text().trim();
      }

      if (type === 'display') {
        if (total === 0) {
          return '<span class="badge bg-light text-muted border" style="font-size: 11px;">-</span>';
        }
        if (pending === 0 && verified > 0) {
          return `<button type="button" class="btn btn-sm btn-outline-success view-consignee-status" data-po-id="${po_id}" data-po-num="${po_num}" style="padding: 2px 10px; font-size:11px; white-space:nowrap; border-radius: 20px; font-weight:500;" title="All ${total} Verified! Click to view details">
            <i class="mdi mdi-check-circle text-success"></i> All Verified
          </button>`;
        } else if (verified === 0 && pending > 0) {
          return `<button type="button" class="btn btn-sm btn-outline-warning view-consignee-status text-dark" data-po-id="${po_id}" data-po-num="${po_num}" style="padding: 2px 10px; font-size:11px; white-space:nowrap; border-radius: 20px; font-weight:500; border-color:#f1b44c;" title="${pending} Pending! Click to view details">
            <i class="mdi mdi-clock-outline text-warning"></i> Pending
          </button>`;
        } else {
          return `<button type="button" class="btn btn-sm btn-outline-secondary view-consignee-status" data-po-id="${po_id}" data-po-num="${po_num}" style="padding: 2px 10px; font-size:11px; white-space:nowrap; border-radius: 20px; font-weight:500;" title="${verified} Verified, ${pending} Pending! Click to view details">
            <span class="text-success font-weight-bold"><i class="mdi mdi-check-circle"></i> ${verified}</span> <span class="text-muted">|</span> <span class="text-warning font-weight-bold"><i class="mdi mdi-clock-outline"></i> ${pending}</span>
          </button>`;
        }
      }
      return total;
    }
  },
  {
    data: "total_value",
    className: "dt-body-right"
  },
  {
  data: "ld_required",
  className: "dt-head-center dt-body-center",
  render: function(data, type) {
    if (type === 'display') {
      const icon = data === 'on'
        ? '<i class="mdi mdi-check-circle mdi-24px" style="color:green;"></i>'
        : '<i class="mdi mdi-close-circle mdi-24px" style="color:red;"></i>';
      return icon + `<span style="display:none;">${data === 'on' ? 1 : 0}</span>`;
    }
    return data === 'on' ? '1' : '0';
  }
},
  { data: "file_name" },
  { data: "unique_id" }
],
autoWidth: false,
  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
  pageLength: 10,
                columnDefs: [
    // 1. Center everything by default
    { targets: '_all', className: 'dt-center' },

    // 2. Right-align PO Value (index 9)
    { targets: [9], className: 'dt-head-right dt-body-right' },

    // 3. Left-align Customer Details (index 3)
    { targets: [3], className: 'dt-head-left dt-body-left' },

    // 4. Action column (index 12)
    { 
      targets: [12],
      width: '150px',
      className: 'dt-head-center dt-body-center'
    },
    {
      targets: [5, 6, 7, 8],
      className: 'dt-head-center dt-body-center'
    }
  ]

            });

            // {
            //             data: "state_name"
            //         },
            //         {
            //             data: "district_name"
            //         },
        } else if (from_date != '' && to_date != '') {
            // alert("i am elseif");
            var data = {
                "action": action,
                "from_date": from_date,
                "to_date": to_date,
                "screen_id_val": screen_id_val,
                "user_type_unique_id": user_type_unique_id,
            };
            var ajax_url = sessionStorage.getItem("folder_crud_link");

            var datatable = table.DataTable({
                destroy: true,
                ordering: true,
                searching: true,
                dom: 'lBfrtip', // Adds the button and column visibility controls to the DOM
                buttons: [{
                        extend: 'copyHtml5',
                        text: 'Copy',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis', // Column visibility button
                        text: 'Column Visibility',
                        action: function(e, dt, node, config) {
                            // Open the column visibility modal when the button is clicked
                            $('#columnVisibilityModal').modal('show');

                            // Populate the modal with checkboxes for each column
                            var columns = dt.columns().header();
                            var form = $('#columnVisibilityForm');
                            form.empty(); // Clear any existing checkboxes

                            // Append checkboxes one by one for each column
                            columns.each(function(header, index) {
                                var isChecked = dt.column(index).visible();
                                var colMarkup = `
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" data-column="${index}" ${isChecked ? 'checked' : ''}>
                                <label class="form-check-label">${$(header).text()}</label>
                            </div>
                        `;
                                form.append(colMarkup); // Append each checkbox in a vertical list
                            });
                        }

                    }
                ],
                ajax: {
                    url: ajax_url,
                    type: "POST",
                    data: data
                },
                columns: [
  { data: "s_no" },
  { data: "po_date" },
  { data: "po_num" },
  {
    data: null,
    render: function(data, type, row) {
      return '<span style="font-weight:bold;">' + row.department + '</span><br>' +
             row.bill_address + '<br>' +
             row.state_name + '<br>' +
             row.district_name + '<br>(' + row.gst_value + ')';
    }
  },
  { data: "executive_name" },
  { data: "pro_cnt" },
  { data: "qty" },
  { data: "cons_cnt", className: "dt-head-center dt-body-center" },
  {
    data: null,
    className: "dt-head-center dt-body-center",
    render: function(data, type, row) {
      let total = parseInt(row.cons_cnt) || 0;
      let verified = parseInt(row.cons_verified_cnt) || 0;
      let pending = parseInt(row.cons_pending_cnt) || 0;
      let po_id = row.raw_unique_id || '';
      if (!po_id && row.unique_id) {
        let m = String(row.unique_id).match(/value="([^"]+)"/);
        if (m) { po_id = m[1]; }
      }
      let po_num = row.raw_po_num || '';
      if (!po_num && row.po_num) {
        po_num = $('<div>').html(row.po_num).text().trim();
      }

      if (type === 'display') {
        if (total === 0) {
          return '<span class="badge bg-light text-muted border" style="font-size: 11px;">-</span>';
        }
        if (pending === 0 && verified > 0) {
          return `<button type="button" class="btn btn-sm btn-outline-success view-consignee-status" data-po-id="${po_id}" data-po-num="${po_num}" style="padding: 2px 10px; font-size:11px; white-space:nowrap; border-radius: 20px; font-weight:500;" title="All ${total} Verified! Click to view details">
            <i class="mdi mdi-check-circle text-success"></i> All Verified
          </button>`;
        } else if (verified === 0 && pending > 0) {
          return `<button type="button" class="btn btn-sm btn-outline-warning view-consignee-status text-dark" data-po-id="${po_id}" data-po-num="${po_num}" style="padding: 2px 10px; font-size:11px; white-space:nowrap; border-radius: 20px; font-weight:500; border-color:#f1b44c;" title="${pending} Pending! Click to view details">
            <i class="mdi mdi-clock-outline text-warning"></i> Pending
          </button>`;
        } else {
          return `<button type="button" class="btn btn-sm btn-outline-secondary view-consignee-status" data-po-id="${po_id}" data-po-num="${po_num}" style="padding: 2px 10px; font-size:11px; white-space:nowrap; border-radius: 20px; font-weight:500;" title="${verified} Verified, ${pending} Pending! Click to view details">
            <span class="text-success font-weight-bold"><i class="mdi mdi-check-circle"></i> ${verified}</span> <span class="text-muted">|</span> <span class="text-warning font-weight-bold"><i class="mdi mdi-clock-outline"></i> ${pending}</span>
          </button>`;
        }
      }
      return total;
    }
  },
  {
    data: "total_value",
    className: "dt-body-right"
  },
  {
  data: "ld_required",
  className: "dt-head-center dt-body-center",
  render: function(data, type) {
    if (type === 'display') {
      const icon = data === 'on'
        ? '<i class="mdi mdi-check-circle mdi-24px" style="color:green;"></i>'
        : '<i class="mdi mdi-close-circle mdi-24px" style="color:red;"></i>';
      return icon + `<span style="display:none;">${data === 'on' ? 1 : 0}</span>`;
    }
    return data === 'on' ? '1' : '0';
  }
},
  { data: "file_name" },
  { data: "unique_id" }
],
autoWidth: false,
  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
  pageLength: 10,
                columnDefs: [
    // 1. Center everything by default
    { targets: '_all', className: 'dt-center' },

    // 2. Right-align PO Value (index 9)
    { targets: [9], className: 'dt-head-right dt-body-right' },

    // 3. Left-align Customer Details (index 3)
    { targets: [3], className: 'dt-head-left dt-body-left' },

    // 4. Action column (index 12)
    { 
      targets: [12],
      width: '150px',
      className: 'dt-head-center dt-body-center'
    },
    {
      targets: [5, 6, 7, 8],
      className: 'dt-head-center dt-body-center'
    }
  ]
            });
        } else {
            // alert("i am else");
            var data = {
                "action": action,
                "from_date": from_date,
                "to_date": to_date,
                "screen_id_val": screen_id_val,
                "user_type_unique_id": user_type_unique_id,
            };
            var ajax_url = sessionStorage.getItem("folder_crud_link");

            var datatable = table.DataTable({
                destroy: true,
                ordering: true,
                searching: true,
                dom: 'LBfrtip', // Adds the button and column visibility controls to the DOM
                buttons: [{
                        extend: 'copyHtml5',
                        text: 'Copy',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis', // Column visibility button
                        text: 'Column Visibility',
                        action: function(e, dt, node, config) {
                            // Open the column visibility modal when the button is clicked
                            $('#columnVisibilityModal').modal('show');

                            // Populate the modal with checkboxes for each column
                            var columns = dt.columns().header();
                            var form = $('#columnVisibilityForm');
                            form.empty(); // Clear any existing checkboxes

                            // Append checkboxes one by one for each column
                            columns.each(function(header, index) {
                                var isChecked = dt.column(index).visible();
                                var colMarkup = `
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" data-column="${index}" ${isChecked ? 'checked' : ''}>
                                <label class="form-check-label">${$(header).text()}</label>
                            </div>
                        `;
                                form.append(colMarkup); // Append each checkbox in a vertical list
                            });
                        }

                    }
                ],
                ajax: {
                    url: ajax_url,
                    type: "POST",
                    data: data
                },
                columns: [
  { data: "s_no" },
  { data: "po_date" },
  { data: "po_num" },
  {
    data: null,
    render: function(data, type, row) {
      return '<span style="font-weight:bold;">' + row.department + '</span><br>' +
             row.bill_address + '<br>' +
             row.state_name + '<br>' +
             row.district_name + '<br>(' + row.gst_value + ')';
    }
  },
  { data: "executive_name" },
  { data: "pro_cnt" },
  { data: "qty" },
  { data: "cons_cnt", className: "dt-head-center dt-body-center" },
  {
    data: null,
    className: "dt-head-center dt-body-center",
    render: function(data, type, row) {
      let total = parseInt(row.cons_cnt) || 0;
      let verified = parseInt(row.cons_verified_cnt) || 0;
      let pending = parseInt(row.cons_pending_cnt) || 0;
      let po_id = row.raw_unique_id || '';
      if (!po_id && row.unique_id) {
        let m = String(row.unique_id).match(/value="([^"]+)"/);
        if (m) { po_id = m[1]; }
      }
      let po_num = row.raw_po_num || '';
      if (!po_num && row.po_num) {
        po_num = $('<div>').html(row.po_num).text().trim();
      }

      if (type === 'display') {
        if (total === 0) {
          return '<span class="badge bg-light text-muted border" style="font-size: 11px;">-</span>';
        }
        if (pending === 0 && verified > 0) {
          return `<button type="button" class="btn btn-sm btn-outline-success view-consignee-status" data-po-id="${po_id}" data-po-num="${po_num}" style="padding: 2px 10px; font-size:11px; white-space:nowrap; border-radius: 20px; font-weight:500;" title="All ${total} Verified! Click to view details">
            <i class="mdi mdi-check-circle text-success"></i> All Verified
          </button>`;
        } else if (verified === 0 && pending > 0) {
          return `<button type="button" class="btn btn-sm btn-outline-warning view-consignee-status text-dark" data-po-id="${po_id}" data-po-num="${po_num}" style="padding: 2px 10px; font-size:11px; white-space:nowrap; border-radius: 20px; font-weight:500; border-color:#f1b44c;" title="${pending} Pending! Click to view details">
            <i class="mdi mdi-clock-outline text-warning"></i> Pending
          </button>`;
        } else {
          return `<button type="button" class="btn btn-sm btn-outline-secondary view-consignee-status" data-po-id="${po_id}" data-po-num="${po_num}" style="padding: 2px 10px; font-size:11px; white-space:nowrap; border-radius: 20px; font-weight:500;" title="${verified} Verified, ${pending} Pending! Click to view details">
            <span class="text-success font-weight-bold"><i class="mdi mdi-check-circle"></i> ${verified}</span> <span class="text-muted">|</span> <span class="text-warning font-weight-bold"><i class="mdi mdi-clock-outline"></i> ${pending}</span>
          </button>`;
        }
      }
      return total;
    }
  },
  {
    data: "total_value",
    className: "dt-body-right"
  },
  {
  data: "ld_required",
  className: "dt-head-center dt-body-center",
  render: function(data, type) {
    if (type === 'display') {
      const icon = data === 'on'
        ? '<i class="mdi mdi-check-circle mdi-24px" style="color:green;"></i>'
        : '<i class="mdi mdi-close-circle mdi-24px" style="color:red;"></i>';
      return icon + `<span style="display:none;">${data === 'on' ? 1 : 0}</span>`;
    }
    return data === 'on' ? '1' : '0';
  }
},
  { data: "file_name" },
  { data: "unique_id" }
],
autoWidth: false,
  lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
  pageLength: 10,
                columnDefs: [
    // 1. Center everything by default
    { targets: '_all', className: 'dt-center' },

    // 2. Right-align PO Value (index 9)
    { targets: [9], className: 'dt-head-right dt-body-right' },

    // 3. Left-align Customer Details (index 3)
    { targets: [3], className: 'dt-head-left dt-body-left' },

    // 4. Action column (index 12)
    { 
      targets: [12],
      width: '150px',
      className: 'dt-head-center dt-body-center'
    },
    {
      targets: [5, 6, 7, 8],
      className: 'dt-head-center dt-body-center'
    }
  ]

            });
        }
        $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
            var columnIdx = $(this).data('column');
            var isVisible = $(this).is(':checked');
            datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
        });

    }

    function get_user_permission() {
        var screen_id_val = $('#screen_id_val').val();
        // alert(screen_id_val);
        var user_type_unique_id = $('#user_type_unique_id').val();
        // alert(user_type_unique_id);
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
            success: function(data) {

                var obj = JSON.parse(data);

                var dataString = obj.data;

                // console.log(dataString);

                var addButton = document.getElementById('add_btn');
                if (dataString.includes('5f8807ff00bf726601')) {
                    addButton.style.visibility = 'visible'; // Show the button
                } else {
                    addButton.style.visibility = 'hidden'; // Hide the button but keep its space
                }
                var listpage = document.getElementById('list');
                if (dataString.includes('5f88083fd50a344823')) {
                    listpage.style.visibility = 'visible'; // Show the button
                } else {
                    listpage.style.visibility = 'hidden'; // Hide the button but keep its space
                }


            },
            error: function(data) {
                alert("Network Error");
            }
        });
    }

    function get_user_permission_1() {
        var screen_id_val = $('#screen_id_val').val();

        var user_type_unique_id = $('#user_type_unique_id').val();

        var data = {
            "screen_id_val": screen_id_val,
            "user_type_unique_id": user_type_unique_id,
            "action": 'user_permission_1',
        };

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");

        // console.log(data);
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function(data) {
                alert(data);
                var obj = JSON.parse(data);

                var dataString = obj.data;


                var listpage = document.getElementById('list_1');
                if (dataString.includes('5f88083fd50a344823')) {
                    listpage.style.visibility = 'visible'; // Show the button
                } else {
                    listpage.style.visibility = 'hidden'; // Hide the button but keep its space
                }


            },
            error: function(data) {
                alert("Network Error");
            }
        });
    }

    function sub_list_datatable(table_id = "", form_name = "", action = "") {


        var table_id = 'po_cancel_datatable';
        // alert(table_id);
        var table = $("#" + table_id);
        var data = {

            "action": 'po_cancel_datatable',
        };
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var datatable = table.DataTable({
            destroy: true,
            ordering: true,
            searching: true,
            stateSave:true,
            "ajax": {
                url: ajax_url,
                type: "POST",
                data: data
            },
            dom: 'lBfrtip',
            buttons: [{
                    extend: 'copyHtml5',
                    text: 'Copy',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis', // Column visibility button
                    text: 'Column Visibility',
                    action: function(e, dt, node, config) {
                        // Open the column visibility modal when the button is clicked
                        $('#columnVisibilityModal').modal('show');

                        // Populate the modal with checkboxes for each column
                        var columns = dt.columns().header();
                        var form = $('#columnVisibilityForm');
                        form.empty(); // Clear any existing checkboxes

                        // Append checkboxes one by one for each column
                        columns.each(function(header, index) {
                            var isChecked = dt.column(index).visible();
                            var colMarkup = `
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" data-column="${index}" ${isChecked ? 'checked' : ''}>
                                <label class="form-check-label">${$(header).text()}</label>
                            </div>
                        `;
                            form.append(colMarkup); // Append each checkbox in a vertical list
                        });
                    }

                }
            ]
        });
        $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
            var columnIdx = $(this).data('column');
            var isVisible = $(this).is(':checked');
            datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
        });
    }

    let currentModalPoId = '';
    let currentConsigneesList = [];

    $(document).on('click', '.view-consignee-status', function(e) {
        e.preventDefault();
        let po_id = $(this).data('po-id');
        let po_num = $(this).data('po-num');
        currentModalPoId = po_id;
        $('#modal_po_num').text(po_num);
        $('#modal_consignee_search').val('');
        $('#consigneeStatusModal').modal('show');
        loadPoConsignees(po_id);
    });

    function loadPoConsignees(po_id) {
        $('#modal_consignee_tbody').html('<tr><td colspan="8" class="text-center py-4 text-muted"><i class="fa fa-spinner fa-spin"></i> Loading consignees...</td></tr>');
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        $.ajax({
            url: ajax_url,
            type: "POST",
            data: {
                action: 'get_po_consignees_verification',
                po_id: po_id
            },
            dataType: 'json',
            success: function(res) {
                if (res.status && res.data) {
                    currentConsigneesList = res.data;
                    $('#modal_total_cons').text(res.total);
                    $('#modal_verified_cons').text(res.verified);
                    $('#modal_pending_cons').text(res.pending);
                    renderConsigneeRows(res.data);
                } else {
                    $('#modal_consignee_tbody').html('<tr><td colspan="8" class="text-center py-3 text-muted">No consignees found for this PO.</td></tr>');
                }
            },
            error: function() {
                $('#modal_consignee_tbody').html('<tr><td colspan="8" class="text-center py-3 text-danger">Failed to load consignee details.</td></tr>');
            }
        });
    }

    function renderConsigneeRows(list) {
        if (!list || list.length === 0) {
            $('#modal_consignee_tbody').html('<tr><td colspan="8" class="text-center py-3 text-muted">No matching consignees found.</td></tr>');
            return;
        }
        let html = '';
        list.forEach(function(row, idx) {
            let isVerified = (row.cons_verify_sts == '1');
            let statusBadge = isVerified 
                ? '<span class="badge bg-success" style="font-size:11px;"><i class="mdi mdi-check-circle"></i> Verified</span>'
                : '<span class="badge bg-warning text-dark" style="font-size:11px;"><i class="mdi mdi-clock-outline"></i> Pending</span>';
            
            let actionBtn = isVerified
                ? `<button type="button" class="btn btn-sm btn-outline-warning text-dark toggle-con-verify" data-id="${row.unique_id}" data-new-status="2" title="Mark as Pending"><i class="mdi mdi-close"></i> Mark Pending</button>`
                : `<button type="button" class="btn btn-sm btn-success toggle-con-verify" data-id="${row.unique_id}" data-new-status="1" title="Mark as Verified"><i class="mdi mdi-check"></i> Verify</button>`;

            let contactInfo = (row.con_contact_name || '-') + (row.con_contact_number ? '<br><small class="text-muted"><i class="mdi mdi-phone"></i> ' + row.con_contact_number + '</small>' : '');
            let locationInfo = (row.district_name || '-') + (row.state_name ? ', ' + row.state_name : '') + (row.con_pincode ? ' - ' + row.con_pincode : '');

            html += `<tr>
                <td class="text-center">${idx + 1}</td>
                <td><b>${row.con_branch || '-'}</b>${row.con_branch_code ? '<br><small class="text-muted">Code: ' + row.con_branch_code + '</small>' : ''}</td>
                <td><small>${row.con_address || '-'}</small></td>
                <td><small>${locationInfo}</small></td>
                <td>${contactInfo}</td>
                <td><small>${row.assigned_team_member || '-'}</small></td>
                <td class="text-center">${statusBadge}</td>
                <td class="text-center">${actionBtn}</td>
            </tr>`;
        });
        $('#modal_consignee_tbody').html(html);
    }

    $('#modal_consignee_search').on('keyup', function() {
        let q = $(this).val().toLowerCase().trim();
        if (!q) {
            renderConsigneeRows(currentConsigneesList);
            return;
        }
        let filtered = currentConsigneesList.filter(function(item) {
            return (item.con_branch && item.con_branch.toLowerCase().includes(q)) ||
                   (item.con_address && item.con_address.toLowerCase().includes(q)) ||
                   (item.district_name && item.district_name.toLowerCase().includes(q)) ||
                   (item.state_name && item.state_name.toLowerCase().includes(q)) ||
                   (item.con_contact_name && item.con_contact_name.toLowerCase().includes(q)) ||
                   (item.con_contact_number && item.con_contact_number.toLowerCase().includes(q));
        });
        renderConsigneeRows(filtered);
    });

    $(document).on('click', '.toggle-con-verify', function() {
        let con_id = $(this).data('id');
        let new_status = $(this).data('new-status');
        let btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        $.ajax({
            url: ajax_url,
            type: "POST",
            data: {
                action: 'quick_toggle_consignee_verification',
                consignee_id: con_id,
                new_status: new_status
            },
            dataType: 'json',
            success: function(resp) {
                if (resp.status) {
                    loadPoConsignees(currentModalPoId);
                    if (typeof get_data === 'function') {
                        get_data();
                    }
                } else {
                    alert('Failed to update verification status.');
                    btn.prop('disabled', false);
                }
            },
            error: function() {
                alert('Network error while updating status.');
                btn.prop('disabled', false);
            }
        });
    });
</script>
