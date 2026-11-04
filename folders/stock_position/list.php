<?php

// Turn on error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

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

    span.d_date {
        white-space: nowrap;
    }

    #stock_position_datatable th {
        text-align: center;
        vertical-align: middle;
        /* optional: vertically center text */
    }

    table.dataTable thead tr th {
        text-align: center;
    }

    table.dataTable tbody td:nth-child(6),
    table.dataTable thead th:nth-child(6),
    table.dataTable tbody td:nth-child(7),
    table.dataTable thead th:nth-child(7),
    table.dataTable tbody td:nth-child(8),
    table.dataTable thead th:nth-child(8) {
        text-align: right;
    }
</style>
<?php
//  $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val = '641ad5d106dc422934';

$user_type_unique_id = $_SESSION['user_type_unique_id'];
?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Stock Position</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
                value="<?php echo $screen_id_val; ?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
                value="<?php echo $user_type_unique_id; ?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active">Stock Position</li>
                </ol>
            </div>

        </div>
        <div>
        </div>
    </div>
</div>

<div class="col-xxl-12">

    <div class="card">
        <div class="card-body">

            <ul class="nav nav-pills arrow-navtabs bg-light mb-3" role="tablist">
                <li class="nav-item" onclick="stock_position_pending()">
                    <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                        <span class="d-none d-sm-block">Pending</span>
                    </a>
                </li>
                <li class="nav-item" onclick="complete_list_datatable()">
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

                            <div class="col-md-1">
                                <div class="mb-3">

                                    <button type="button" class="btn btn-primary btn-lg gos"
                                        onclick="get_data()">Go</button>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="list">
                            <div class="table-responsive">
                                <table id="stock_position_datatable"
                                    class="table table-bordered nowrap table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">S.No</th>
                                            <th rowspan="2">PO No </th>
                                            <!-- <th rowspan="2">PO No.</th> -->
                                            <th rowspan="2">Customer Name</th>
                                            <th rowspan="2">Executive Name</th>
                                            <th colspan="2">No. of.</th>
                                            <th colspan="2">Qty</th>
                                            <th rowspan="2">Value</th>
                                            <th rowspan="2">Attach</th>
                                            <th rowspan="2">Due Date</th>
                                            <th rowspan="2">Status</th>
                                            <th rowspan="2">Action</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align:right;">Items</th>
                                            <th>Consignee</th>
                                            <th>Order</th>
                                            <th>Balance</th>
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
                    <table id="complete_stock_position_datatable"
                        class="table table-bordered table-striped align-middle">
                        <div class="row align-items-end">
                           <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label from-date-label">From Date</label>
                                    <input type="date" class="form-control" 
                                        id="from_date_com" 
                                        name="from_date_com" 
                                        value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label from-date-label">To Date</label>
                                    <input type="date" class="form-control" 
                                        id="to_date_com" 
                                        name="to_date_com" 
                                        value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>


                            <div class="col-md-1">
                                <div class="mb-3">

                                    <button type="button" class="btn btn-primary btn-lg gos"
                                        onclick="get_data_com()">Go</button>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="list_1"></div>
                        <div class="table-responsive mb-4">

                            <thead>
                                <tr>
                                    <th rowspan="2">S.No</th>
                                    <th rowspan="2">PO No </th>
                                    <!-- <th rowspan="2">PO No. </th> -->
                                    <th rowspan="2">Customer Name</th>
                                    <th rowspan="2">Executive Name</th>
                                    <th rowspan="2">No of Items</th>
                                    <th colspan="2">Qty</th>
                                    <th rowspan="2" style="text-align:center">Billed Qty</th>
                                    <th rowspan="2" style="text-align:center">Value</th>
                                    <th rowspan="2" style="text-align:center">Attach</th>
                                    <th rowspan="2" style="text-align:center">Action</th>

                                </tr>
                                <tr>
                                    <th>Order</th>
                                    <th>Stock</th>
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
</div><!-- end card -->
</div>
<!--end col-->

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

        // alert("hi");
        window.location = "folders/stock_position/excel.php";
    });
    $("#export1").click(function () {
        // alert("hi");
        window.location = "folders/stock_position/excel_complete.php";
    });


    function print_pdf_1(file_name) {

        onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
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
        // 
        console.log(data);
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {

                var obj = JSON.parse(data);

                var dataString = obj.data;

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
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {

                var obj = JSON.parse(data);

                var dataString = obj.data;

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
