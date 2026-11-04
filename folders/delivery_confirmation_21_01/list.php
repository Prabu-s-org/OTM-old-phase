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
    .width_s{ width: 4.49% !important;}
  .select2-container{
        width: 100% !important;
    }
</style>
<?php
$screen_id_val = '641ad8d856caa93768';
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];
?>

<?php
$staff_ids = $_SESSION['staff_id'];


if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {
    $team_members_list = assign_team_member($staff_ids); // returns list
    $team_members_options = $team_members_list[0]['staff_name'] ?? '';

    $team_members_options_id = $team_members_list[0]['staff_id'] ?? '';
} else {
    $team_members_options = assign_team_member();

    $team_members_options = select_option($team_members_options, "All");
}
?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Delivery Confirmation</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" value="<?php echo $screen_id_val; ?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" value="<?php echo $user_type_unique_id; ?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Form</a></li>
                    <li class="breadcrumb-item active">Delivery</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="col-xxl-12">
    <div class="card">
        <div class="card-body">

            <!-- Tabs -->
            <ul class="nav nav-pills arrow-navtabs bg-light mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#arrow-pending" role="tab">
                        <span class="d-none d-sm-block">Pending</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#arrow-completed" role="tab">
                        <span class="d-none d-sm-block">Completed</span>
                    </a>
                </li>
            </ul>

            <!-- ------------------------------------Tab panes ------------------------------------------------------------------------------------------>
            <div class="tab-content">

                <!-- Pending Tab -->
                <div class="tab-pane active" id="arrow-pending" role="tabpanel">
                    <div class="row align-items-end">
                        <div class="col-md-2 mb-3">
                            <label class="form-label">From Date</label>
                            <input type="date" class="form-control" id="from_date_de" name="from_date_de">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">To Date</label>
                            <input type="date" class="form-control" id="to_date_de" name="to_date_de">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Select Date Type</label>
                            <select class="form-select" id="opt3" name="opt3">
                                <option value="">Select</option>
                                <option value="40">PO Date</option>
                                <option value="50">Invoice Date</option>
                                <option value="60">Delivery Date</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Team Members</label>
                            <select name="team_mem3" id="team_mem3" class="select2 form-control">
                                <?php if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') { ?>
                                    <option value="<?php echo $team_members_options_id; ?>"><?php echo $team_members_options; ?></option>
                                <?php } else {
                                    echo $team_members_options;
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-1 mb-3">
                            <button type="button" class="btn btn-primary btn-lg gos" onclick="get_data_delivery()">Go</button>
                        </div>
                         <div class="col-md-2 text-end">
                            <div class="mb-3">
                                <?php if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741" ||$_SESSION['user_type_unique_id'] == "5f97fc3257f2525529") { ?>
                                    <a href="index.php?file=delivery_confirmation/pending_list"
                                        class="btn btn-primary waves-effect waves-light">OverAll
                                        Approval</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="deleivery_datatable" class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">S.No</th>
                                    <th style="text-align: center;">Po No</th>
                                    <th style="width: 150px; text-align: center;">Location</th>

                                    <th style="text-align: center;">Followed By</th>
                                    <th style="text-align: center;">Invoice</th>
                                    <th style="text-align: center;">DC</th>
                                    <th style="text-align: center;">Delivery Mode</th>
                                    <th style="text-align: center;">Delivery Date</th>
                                    <th style="text-align: center;">Attachment</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!---------------------------------------------------------------------------------------- Completed Tab -->

                <div class="tab-pane " id="arrow-completed" role="tabpanel">
                    <div class="row align-items-end">
                        <div class="col-md-2 mb-3">
                            <label class="form-label">From Date</label>
                            <input type="date" class="form-control" id="comfrom_date_de" name="comfrom_date_de" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">To Date</label>
                            <input type="date" class="form-control" id="comto_date_de" name="comto_date_de" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Select Date Type</label>
                            <select class="form-select" id="comopt3" name="comopt3">
                                <option value="">Select</option>
                                <option value="40">PO Date</option>
                                <option value="50">Invoice Date</option>
                                <option value="60">Delivery Date</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Team Members</label>
                            <select name="comteam_mem4" id="comteam_mem4" class="select2 form-control">
                                <?php if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') { ?>
                                    <option value="<?php echo $team_members_options_id; ?>"><?php echo $team_members_options; ?></option>
                                <?php } else {
                                    echo $team_members_options;
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-1 mb-3">
                            <button type="button" class="btn btn-primary btn-lg gos" onclick="get_data_comdelivery()">Go</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="deleivery_comdatatable" class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th class="width_s" >S.No</th>
                                    <th style="text-align: center;">Po No</th>
                                    <th style="text-align: center;">Location</th>
                                    <th style="text-align: center;">Followed By</th>
                                    <th style="text-align: center;">Invoice</th>
                                    <th style="text-align: center;">DC</th>
                                    <th style="text-align: center;">Delivery Mode</th>
                                    <th style="text-align: center;">Delivery Date</th>
                                    <th style="text-align: center;">Attachment</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                
<!------------------------------------------------end------------------------------------------------------------------------------------------------------------->
            </div> <!-- end tab-content -->

        </div> <!-- end card-body -->
    </div> <!-- end card -->
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
    $("#export3").click(function() {
        // alert("hi");
        window.location = "folders/dispatch/excel_complete.php";
    });

    $(document).ready(function() {
        get_data_delivery();
        get_data_comdelivery();
        //      $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
        //     $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        // });
    });

    function get_data_delivery() {
        sub_list_datatable_delivery('deleivery_datatable', form_name, 'deleivery_datatable');
    }

    function get_data_comdelivery() {
        sub_list_datatable_comdelivery('deleivery_comdatatable', form_name, 'deleivery_comdatatable');
    }

    function sub_list_datatable_delivery(table_id = "", form_name = "", action = "") {

        var table_id = 'deleivery_datatable';

        var screen_id_val = $('#screen_id_val').val();
        var user_type_unique_id = $('#user_type_unique_id').val();
        var team_mem3 = $('#team_mem3').val();
        var table = $("#" + table_id);
        var from_date = $("#from_date_de").val();
        var to_date = $("#to_date_de").val();
        var opt3 = $("#opt3").val();
        var action = "deleivery_datatable";
        var data = {
            "action": action,
            "from_date": from_date,
            "to_date": to_date,
            "opt3": opt3,
            "screen_id_val": screen_id_val,
            "team_mem3": team_mem3,
            "user_type_unique_id": user_type_unique_id,
        };

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        var datatable = table.DataTable({
            destroy: true,
            ordering: true,
            searching: true,
            stateSave:true,
            ajax: {
                url: ajax_url,
                type: "POST",
                data: data
            },
             columnDefs: [
    {
        targets: [8,9], // columns 1 to 8 (0-indexed)
        className: 'text-center'    // Applies Bootstrap's center alignment
    }
],
            dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
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
                    extend: 'colvis',
                    text: 'Column Visibility',
                    action: function(e, dt, node, config) {
                        $('#columnVisibilityModal').modal('show');
                        var columns = dt.columns().header();
                        var form = $('#columnVisibilityForm');
                        form.empty();
                        columns.each(function(header, index) {
                            var isChecked = dt.column(index).visible();
                            var colMarkup = `
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" data-column="${index}" ${isChecked ? 'checked' : ''}>
                                <label class="form-check-label">${$(header).text()}</label>
                            </div>
                        `;
                            form.append(colMarkup);
                        });
                    }
                }
            ],
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            pageLength: 10
        });

        $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
            var columnIdx = $(this).data('column');
            var isVisible = $(this).is(':checked');
            datatable.column(columnIdx).visible(isVisible);
        });
    }



    function sub_list_datatable_comdelivery(table_id = "", form_name = "", action = "") {
        var table_id_3 = 'deleivery_comdatatable';
        var action = 'deleivery_comdatatable';
        var screen_id_val = $('#screen_id_val').val();
        var user_type_unique_id = $('#user_type_unique_id').val();
        var team_mem3 = $('#comteam_mem4').val();

        var table = $("#" + table_id_3);
        var from_date = $("#comfrom_date_de").val();
        var to_date = $("#comto_date_de").val();
        var opt3 = $("#comopt3").val();
        var data = {

            "action": 'deleivery_comdatatable',
            "from_date": from_date,
            "to_date": to_date,
            "opt3": opt3,
            "screen_id_val": screen_id_val,
            "team_mem3": team_mem3,
            "user_type_unique_id": user_type_unique_id,
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
            // dom: 'Bfrtip',
            columnDefs: [
    {
        targets: [8,9], // columns 1 to 8 (0-indexed)
        className: 'text-center'    // Applies Bootstrap's center alignment
    }
],
            dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
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
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            pageLength: 10 // Default selected value
        });
        $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
            var columnIdx = $(this).data('column');
            var isVisible = $(this).is(':checked');
            datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
        });
    }



    $(document).ready(function() {
        get_user_permission();
        get_user_permission_1();

    });

    function get_user_permission() {
        var screen_id_val = $('#screen_id_val').val();
        // alert(screen_id_val);
        var user_type_unique_id = $('#user_type_unique_id').val();

        var data = {
            "screen_id_val": screen_id_val,
            "user_type_unique_id": user_type_unique_id,
            "action": 'user_permission',
        };

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");
        // 
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function(data) {

                var obj = JSON.parse(data);

                var dataString = obj.data;

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
        // alert(screen_id_val);
        var user_type_unique_id = $('#user_type_unique_id').val();

        var data = {
            "screen_id_val": screen_id_val,
            "user_type_unique_id": user_type_unique_id,
            "action": 'user_permission_1',
        };

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");
        // 
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function(data) {

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


    function get_user_permission_2() {
        var screen_id_val = $('#screen_id_val').val();
        // alert(screen_id_val);
        var user_type_unique_id = $('#user_type_unique_id').val();

        var data = {
            "screen_id_val": screen_id_val,
            "user_type_unique_id": user_type_unique_id,
            "action": 'user_permission_2',
        };

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");
        // 
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function(data) {

                var obj = JSON.parse(data);

                var dataString = obj.data;

                // console.log(dataString);

                // var addButton = document.getElementById('add_btn');
                // if (dataString.includes('5f8807ff00bf726601')) {
                // 	addButton.style.visibility = 'visible';  // Show the button
                // } else {
                // 	addButton.style.visibility = 'hidden';   // Hide the button but keep its space
                // }
                var listpage = document.getElementById('list_2');
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

    function get_list3() {
        var team_mem = document.getElementById('team_mem3').value;
        sub_list_datatable_delivery(table_id, form_name, action);
    }
</script>
