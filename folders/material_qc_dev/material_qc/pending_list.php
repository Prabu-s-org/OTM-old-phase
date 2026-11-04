<?php include 'function.php'; ?>

<?php

include '../../config/dbconfig.php';
include '../../inc/header.php';
include '../../inc/footer.php';

?>
<div class="row">
    <div class="card">
        <div class="card-body">
            <center>
                <h3>PENDING LIST</h3>
            </center>
        </div>
    </div>

</div>
<input type="hidden" id="team_mem" name ="team_mem">
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="doc_pending_list_datatable" class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Selection<br>(Select All)
                                <?php echo '<input type="checkbox"  id="select_all">' ?>
                            </th>
							<th>S.No</th>
							<th>DC No / Date</th>
							<!-- <th>DC Date</th> -->
							<th>PO No / Date</th>
							<!-- <th>PO Date</th> -->
							<th>Followed By</th>
							<!-- <th>Consignee</th> -->
							<!-- <th>Department</th> -->
							<!-- <th>Ledger Name</th> -->
							<th>Location</th>
							<th>Invoice No / Date</th>
							<!-- <th>Invoice Date</th> -->
							<th>Value</th>
							<th>PO</th>
							<th>DC</th>
							<th>IR</th>
							<th>Invoice</th>
							<th>Compare</th>
							<th>A/C Team Verify Status</th>
							<th>A/C Approved by</th>
							<!-- <th>Material QC Status</th>
							<th>Reject Reason</th>
							<th>Material QC Approved by</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group row ">
                    <div class="col-md-12" align="right">
                        <?php echo btn_cancel($btn_cancel); ?>
                        <button type="button" class="btn btn-primary waves-effect waves-light" id="approve_btn"
                            onclick="approve_qc()">Approve</button>
                        <!-- <button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_invoice_create()">Save</button> -->
                    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    document.getElementById('select_all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.myCheck');
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = this.checked;
        }.bind(this));
    });

    function pending_list() {	
	var table ="doc_pending_list_datatable";

	var table = $("#" + table);

	// var ac_team_verifiy_status = $("#ac_team_verifiy_status").val();

	var data = {
		
		"action" : "pending_list_datatable",
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
}

function approve_qc(){

// alert("cfvgb");
	var internet_status = is_online();

	const checked = document.querySelectorAll('.myCheck:checked');

	for (var i = 0; i < checked.length; i++) {

		var checkbox = checked[i];

		var approved_by = checkbox.parentElement.querySelector('#approved_by').value;

	// alert(approved_by);
			
		var doc_approval_sts = checkbox.parentElement.querySelector('#doc_approval_sts').value;
		// alert(doc_approval_sts);
		var invoice_unique_id = checkbox.parentElement.querySelector('#invoice_id').value;
        // alert(invoice_unique_id);
		var dc_number = checkbox.parentElement.querySelector('#dc_number').value;
        // alert(dc_number);


	// console.log(approved_by);
	// console.log(doc_approval_sts);
	// console.log(invoice_unique_id);

	var data = "approved_by=" + approved_by + "&approval_status=" +
	doc_approval_sts + "&invoice_unique_id=" + invoice_unique_id + "&dc_number=" + dc_number;
	// var data = "approved_by=" + approved_by +"&approval_status=" + doc_approval_sts + "&inovoice_unique_id=" + inovoice_unique_id;

	data+="&action=approval_list_qc";

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");

	$.ajax({

		type:"POST",
		url:ajax_url,
		data:data,
		beforeSend: function() {
			$(".po_delivery_add_update_btn").attr("disabled", "disabled");
			$(".po_delivery_add_update_btn").text("Loading...");
		},
		success: function(data) {
			sweetalert("approve");
			window.reload();
			

		},
		error: function(data) {
			alert("Network Error");
		}

	});
	}


}


</script>
