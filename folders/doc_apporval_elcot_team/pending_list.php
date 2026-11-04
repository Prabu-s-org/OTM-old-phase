<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>
<?php
include '../../config/dbconfig.php';
include '../../inc/header.php';
include '../../inc/footer.php';

$btn_text           = "Save";
$btn_action         = "create";
$is_btn_disable     = "";

$unique_id          = "";

$user_type               = "";
$under_user_type        = "";
$exp_under_user_type     = "";

$is_active          = 1;

$session_approved_by = $_SESSION["staff_name"];


?>
<style>
    label {
        /* font-weight: bold;
  color: black; */
        margin-right: 20px;
        /* You can add more styles as needed */
    }
    #pos{
        width: 129.8px;
    }

    /* .form-label {
  display: inline-block;
  width: 100px;
  text-align: left;
}

.form-label {
 
  margin-left: 10px;
}

.form-label span {
  margin-left: 10px;
} */
/* 
    .table-responsive {
        margin-top: 20px;
    }

    table#pending_approval_datatable {
        width: 100%;
        border-collapse: collapse;
    }

    table#pending_approval_datatable thead {
        background-color: #343a40;
        color: #ffffff;
        text-align: center;
    }

    table#pending_approval_datatable th,
    table#pending_approval_datatable td {
        padding: 10px;
        vertical-align: middle;
        border: 1px solid #dee2e6;
    }

    table#pending_approval_datatable th {
        font-weight: bold;
    }

    table#pending_approval_datatable tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    table#pending_approval_datatable tbody tr:hover {
        background-color: #e9ecef;
    }

    table#pending_approval_datatable td {
        text-align: center;
    }

    .table-responsive::-webkit-scrollbar {
        height: 8px;
        width: 8px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: #adb5bd;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background-color: #f1f1f1;
    } */
</style>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Pending List</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
                value="<?php echo $screen_id_val; ?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
                value="<?php echo $user_type_unique_id; ?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Form</a></li>
                    <li class="breadcrumb-item active">Operation Approval</li>
                 
                </ol>
            </div>
        </div>

      
    </div>
</div>

<div class="row">
    <div class="card">
        <div class="col-12">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="pending_approval_datatable" class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Selection<br>(Select All)
                                <?php echo '<input type="checkbox" id="select_all">' ?></th>
                                <th>S.No</th>
                                <th id="pos">PO No</th>
                                <!-- <th>PO Date</th> -->
                                <th>Followed By</th>
                                <th>Customer</th>
                                <th>Location</th>
                                <th id="dcs">DC No</th>
                                <!-- <th>DC Date</th> -->
                                <th id="invs">Invoice No</th>
                                <!-- <th>Invoice Date</th> -->
                                <th>PO</th>
                                <th>DC</th>
                                <th>IR</th>
                                <th>Invoice</th>
                                <th>Comparison</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>


                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3 mb-3">
            <div class="form-group row ">
                <div class="col-md-12" align="right">
                
                    <?php echo btn_cancel($btn_cancel); ?>
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="approve_btn"  onclick="approval()">Approve</button>
                    <!-- <button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_invoice_create()">Save</button> -->
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
    document.getElementById('select_all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.myCheck');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = this.checked;
        }.bind(this));
    });
    
    $(document).ready(function() {
        // Initialize DataTable
        var table_id = 'pending_approval_datatable';

        var table = $("#" + table_id);

        var data = {
            "action": 'pending_approval_datatable',
        };
        var ajax_url = sessionStorage.getItem("folder_crud_link");

        var datatable = table.DataTable({
            ordering: true,
            searching: true,
            stateSave:true,
            "ajax": {
                url: ajax_url,
                type: "POST",
                data: data
            },
            dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
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
		]
        });
        $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
			var columnIdx = $(this).data('column');
			var isVisible = $(this).is(':checked');
			datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
		});
    });

    // function init_datatable(table_id = '', form_name = '', action = '') {

    //     // Get the table element by ID
    //     var table = $("#" + table_id);

    //     // Fetch the value of doc_approval_sts from a form or element
    //     var doc_approval_sts = $("#" + form_name + " #doc_approval_sts").val();

    //     // Define the data to be sent in the AJAX request
    //     var data = {
    //         // Uncomment and adjust these lines if needed
    //         //"doc_approval_sts": doc_approval_sts,
    //         //"action": action
    //     };

    //     // Retrieve the AJAX URL from sessionStorage
    //     var ajax_url = sessionStorage.getItem("folder_crud_link");

    //     // Initialize the DataTable with custom settings
    //     var datatable = table.DataTable({
    //         ordering: true, // Enable column ordering
    //         searching: true, // Enable searching/filtering
    //         "ajax": {
    //             url: ajax_url, // URL for the AJAX request
    //             type: "POST", // HTTP method for the AJAX request
    //             data: data, // Data to be sent in the AJAX request
    //             dataSrc: function(json) {
    //                 if (json.status) {
    //                     return json.data[0]; // Adjust this based on your JSON structure
    //                 } else {
    //                     return [];
    //                 }
    //             }
    //         },
    //         "processing": true, // Show processing indicator
    //         "serverSide": true, // Enable server-side processing
    //         "columns": [
    //             { "data": "sno" }, // S.No column
    //             { "data": "po_num" }, // PO No column
    //             { "data": "po_date" }, // PO Date column
    //             { "data": "department" }, // Department column
    //             { "data": "con_address" }, // Location column
    //             { "data": "invoice_no" }, // Invoice No column
    //             { "data": "invoice_date" }, // Invoice Date column
    //             { "data": "po" }, // PO button/link column
    //             { "data": "dc" }, // DC button/link column
    //             { "data": "ir" }, // IR button/link column
    //             { "data": "invoice" }, // Invoice button/link column
    //             { "data": "comparison" }, // Comparison column
    //             { "data": "status" }, // Status column
    //             { "data": "approved_by" } // Approved by column
    //         ]
    //     });

    //     return datatable;
    // }

    
</script>
