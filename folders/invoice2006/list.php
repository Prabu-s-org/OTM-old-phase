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

    #icon {
        font-size: x-large;
    }

    table.dataTable.nowrap td {
        white-space: unset;
    }

    .sorting_asc::before {
        display: none;
    }

    span.po_date {
        white-space: nowrap;
    }

    .text-end {
    text-align: right !important;
}
 .text-right {
        text-align: right !important;
    }
  th {
    text-align: center !important;
}


</style>
<?php
$screen_id_val = '641ad605643eb62575';
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];
?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Invoice Dc</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
                value="<?php echo $screen_id_val; ?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
                value="<?php echo $user_type_unique_id; ?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                    <li class="breadcrumb-item active">Invoice</li>
                </ol>
            </div>

        </div>
        <div>
        </div>

    </div>
</div>


<!-- <div class="card">
    <div class="card-body">
        <ul class="nav nav-pills arrow-navtabs bg-light mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                    <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                    <span class="d-none d-sm-block">Assign Stock to Consignee</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#arrow-contact" role="tab">
                    <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                    <span class="d-none d-sm-block">DC & Invoice Details Pending</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#arrow-con" role="tab">
                    <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                    <span class="d-none d-sm-block">DC & Invoice Details Completed</span>
                </a>
            </li>
        </ul>
        <div class="tab-content ">
            <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                <div class="row">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label from-date-label">From Date</label>
                                <input type="date" class="form-control" id="from_date_ass" name="from_date_ass">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label from-date-label">To Date</label>
                                <input type="date" class="form-control" id="to_date_ass" name="to_date_ass">
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="mb-3">

                                <button type="button" class="btn btn-primary btn-lg"
                                    onclick="ass_stock_data()">Go</button>
                            </div>
                        </div>


                    </div>
                    <div class="row" id="list">
                        <div class="table-responsive">
                            <table id="stock_processing_datatable"
                                class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>PO Date </th>
                                        <th>PO Number </th>
                                        <th>Executive Name</th>
                                        <th>Customer </th>
                                        <th>No.Of.Items</th>
                                        <th >Qty</th>
                                        <th >Value</th>

                                        <th>Status</th>
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
            <div class="tab-pane" id="arrow-contact" role="tabpanel">

                <?php
                $staff_ids = $_SESSION['staff_id'];
                
                // if ($_SESSION['user_type_unique_id'] != '5f97fc3257f2525529' && $_SESSION['user_type_unique_id'] != '65deef78ba17d65741') {
                if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {
                    $team_members_list = assign_team_member($staff_ids); // returns list
                    $team_members_options = $team_members_list[0]['staff_name'] ?? '';

                    $team_members_options_id = $team_members_list[0]['staff_id'] ?? '';
                

                } else {
                    // $staff_ids
                    $team_members_options = assign_team_member();

                    $team_members_options = select_option($team_members_options, "All");
                }
                ?>
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <div class="mb-3">
                        <label>Team Member</label>
                            <?php
                            // if ($_SESSION['user_type_unique_id'] != '5f97fc3257f2525529' && $_SESSION['user_type_unique_id'] != '65deef78ba17d65741') {
                                if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') { 
                                ?>
                                <select name="team_mem" id="team_mem" class="select2 form-control" oninput="get_list();">

                                    <option value="<?php echo $team_members_options_id; ?>">
                                        <?php echo $team_members_options; ?></option>
                                </select>
                                <?php

                            } else { ?>
                                <select name="team_mem" id="team_mem" class="select2 form-control" oninput="get_list();">
                                    <?php echo $team_members_options; ?>
                                </select>
                                <?php
                            }

                            ?>

                        </div>
                    </div>
                </div>
                <br>
                <div class="row" id="list_1">
                    <div class="table-responsive">
                        <table id="invoice_datatable" class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th rowspan='2'>S.No</th>
                                    <th rowspan='2'>DC No / Date</th>
                                    <th rowspan='2' style="width: 180px;">INV No / Date</th>
                                    <th rowspan='2'>PO Number</th>
                                    <th rowspan='2'>Customer Details</th>
                                    <th rowspan='2'>Contact</th>
                                    <th rowspan='2'>Con.Details</th>
                                    <th rowspan='2'>Qty</th>
                                    <th rowspan='2'>Value</th>
                                    <th colspan='3' style="text-align: center;">Status</th>
                                    <th rowspan='2'>Action</th>
                                </tr>
                                <tr>
                                    <th>Verify</th>
                                    <th>Approval</th>
                                    <th>Document</th>
                        </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
<br>
<div class="tab-pane active" id="arrow-con" role="tabpanel">
                <div class="row">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label from-date-label">From Date</label>
                                <input type="date" class="form-control" id="from_date_ass" name="from_date_ass">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label from-date-label">To Date</label>
                                <input type="date" class="form-control" id="to_date_ass" name="to_date_ass">
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="mb-3">

                                <button type="button" class="btn btn-primary btn-lg"
                                    onclick="ass_stock_data()">Go</button>
                            </div>
                        </div>


                    </div>
                    <div class="row" id="list">
                        <div class="table-responsive">
                            <table id="stock_processing_datatable"
                                class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>PO Date </th>
                                        <th>PO Number </th>
                                        <th>Executive Name</th>
                                        <th>Customer </th>
                                        <th>No.Of.Items</th>
                                        <th >Qty</th>
                                        <th >Value</th>

                                        <th>Status</th>
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
    </div>
</div> -->
<div class="card">
    <div class="card-body">
        <ul class="nav nav-pills arrow-navtabs bg-light mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                    <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                    <span class="d-none d-sm-block">Assign Stock to Consignee</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#arrow-pending" role="tab">
                    <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                    <span class="d-none d-sm-block">DC & Invoice Pending</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#arrow-completed" role="tab">
                    <span class="d-block d-sm-none"><i class="mdi mdi-email-outline"></i></span>
                    <span class="d-none d-sm-block">DC & Invoice Completed</span>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Tab 1: Assign Stock -->
            <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                <div class="row">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label from-date-label">From Date</label>
                                <input type="date" class="form-control" id="from_date_ass" name="from_date_ass">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label from-date-label">To Date</label>
                                <input type="date" class="form-control" id="to_date_ass" name="to_date_ass">
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="mb-3">

                                <button type="button" class="btn btn-primary btn-lg"
                                    onclick="ass_stock_data()">Go</button>
                            </div>
                        </div>


                    </div>
                    <div class="row" id="list">
                        <div class="table-responsive">
                            <table id="stock_processing_datatable"
                                class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>PO Date </th>
                                        <th>PO Number </th>
                                        <th>Executive Name</th>
                                        <th>Customer </th>
                                        <th>No.Of.Items</th>
                                        <th >Qty</th>
                                        <th >Value</th>

                                        <th>Status</th>
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

            <!-- Tab 2: DC & Invoice Pending -->
            <div class="tab-pane" id="arrow-pending" role="tabpanel">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label>Team Member</label>
                            <?php
                            $staff_ids = $_SESSION['staff_id'];
                            if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {
                                $team_members_list = assign_team_member($staff_ids);
                                $team_members_options = $team_members_list[0]['staff_name'] ?? '';
                                $team_members_options_id = $team_members_list[0]['staff_id'] ?? '';
                            ?>
                                <select name="team_mem" id="team_mem" class="select2 form-control" oninput="get_list();">
                                    <option value="<?php echo $team_members_options_id; ?>"><?php echo $team_members_options; ?></option>
                                </select>
                            <?php } else {
                                $team_members_options = assign_team_member();
                                $team_members_options = select_option($team_members_options, "All");
                            ?>
                                <select name="team_mem" id="team_mem" class="select2 form-control" oninput="get_list();">
                                    <?php echo $team_members_options; ?>
                                </select>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="invoice_datatable" class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th >S.No</th>
                                <!-- <th rowspan="2">DC No / Date</th>
                                <th rowspan="2" style="width: 180px;">INV No / Date</th> -->
                                <th >PO Number</th>
                                <th >Customer Details</th>
                                <th >Contact</th>
                                <th >Con.Details</th>
                                <th >Qty</th>
                                <th >Value</th>
                                <th >Verify Status</th>
                                <th >Action</th>
                            </tr>
                           
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Tab 3: DC & Invoice Completed -->
            <div class="tab-pane" id="arrow-completed" role="tabpanel">
    
             

                <div class="table-responsive">
                    <table id="invoice_datatable_pending" class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th rowspan="2">S.No</th>
                                <th rowspan="2">DC No / Date</th>
                                <th rowspan="2" style="width: 180px;">INV No / Date</th>
                                <th rowspan="2">PO Number</th>
                                <th rowspan="2">Customer Details</th>
                                <th rowspan="2">Contact</th>
                                <th rowspan="2">Con.Details</th>
                                <th rowspan="2">Qty</th>
                                <th rowspan="2">Value</th>
                                <th colspan="3" style="text-align: center;">Status</th>
                                <th rowspan="2">Action</th>
                            </tr>
                            <tr>
                                <th>Verify</th>
                                <th>Approval</th>
                                <th>Document</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
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
                <button type="button" class="btn btn-primary" id="saveColumnVisibility">Save Changes</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#export").click(function () {
        window.location = "folders/invoice/excel.php";
    });
    $("#export1").click(function () {
        var selectedColumns = $(".exportColumn:checked").map(function () {
            return $(this).val();
        }).get(); // Get selected columns as an array

        if (selectedColumns.length === 0) {
            alert("Please select at least one column to export!");
            return;
        }
        var selectedColumnsStr = selectedColumns.join(",");
        window.location = "folders/invoice/excel_invoice.php?&columns=" + selectedColumnsStr;

    });
    $("#export2").click(function () {

        var selectedColumns = $(".exportColumn:checked").map(function () {

            return $(this).val();
        }).get(); // Get selected columns as an array
        if (selectedColumns.length === 0) {
            alert("Please select at least one column to export!");
            return;
        }
        var selectedColumnsStr = selectedColumns.join(",");
        window.location = "folders/invoice/excel_invoicetab2.php?columns=" + selectedColumnsStr;
    });

    $(document).ready(function () {
        allocation_list_datatable('stock_processing_datatable', form_name, 'stock_processing_datatable');
       allocation_list('invoice_datatable_pending',form_name,'invoice_datatable_pending');
        ass_stock_data();
    });
    function ass_stock_data() {
        allocation_list_datatable('stock_processing_datatable', form_name, 'stock_processing_datatable');

    }


    function allocation_list_datatable(table_id = "", form_name = "", action = "") {
        var table_id = 'stock_processing_datatable';
        var table = $("#" + table_id);
        var from_date = $("#from_date_ass").val();
        var to_date = $("#to_date_ass").val();

        var screen_id_val = $('#screen_id_val').val();
        var user_type_unique_id = $('#user_type_unique_id').val();

        var data = {
            "from_date": from_date,
            "to_date": to_date,
            "action": 'stock_processing_datatable',
            "screen_id_val": screen_id_val,
            "user_type_unique_id": user_type_unique_id,
        };

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        var datatable = table.DataTable({
            destroy: true, //new line
            ordering: true,
            searching: true,
            "ajax": {
                url: ajax_url,
                type: "POST",
                data: data
            },
            dom: 'Bfrtip',
             // Adds the button and column visibility controls to the DOM
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: 'Copy',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'colvis', // Column visibility button
                    text: 'Column Visibility',
                    action: function (e, dt, node, config) {
                        // Open the column visibility modal when the button is clicked
                        $('#columnVisibilityModal').modal('show');

                        // Populate the modal with checkboxes for each column
                        var columns = dt.columns().header();
                        var form = $('#columnVisibilityForm');
                        form.empty(); // Clear any existing checkboxes

                        // Append checkboxes one by one for each column
                        columns.each(function (header, index) {
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
             columnDefs: [
        {
            targets: [5, 6, 7], // 5=No.Of.Items, 6=Qty (item_qty), 7=Value (stock_value)
            className: 'dt-body-right'
        }
    ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10 // Default selected value
        });

        $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
            var columnIdx = $(this).data('column');
            var isVisible = $(this).is(':checked');
            datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
        });
    }
    $(document).ready(function () {
        get_user_permission();
        get_user_permission_1();
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

        console.log(data);
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {

                var obj = JSON.parse(data);

                var dataString = obj.data;

                console.log(dataString);

                var listpage = document.getElementById('list');
                if (dataString.includes('5f88083fd50a344823')) {
                    listpage.style.visibility = 'visible';  // Show the button
                } else {
                    listpage.style.visibility = 'hidden';   // Hide the button but keep its space
                }


            },
            error: function (data) {
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

        console.log(data);
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {

                var obj = JSON.parse(data);

                var dataString = obj.data;

                console.log(dataString);
                var listpage = document.getElementById('list_1');
                if (dataString.includes('5f88083fd50a344823')) {
                    listpage.style.visibility = 'visible';  // Show the button
                } else {
                    listpage.style.visibility = 'hidden';   // Hide the button but keep its space
                }


            },
            error: function (data) {
                alert("Network Error");
            }
        });
    }
</script>
